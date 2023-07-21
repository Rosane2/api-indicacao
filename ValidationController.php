<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ValidationController extends Controller {
   // Validar CPF
   public function validaCPF($cpf) {

		// Extrai somente os números
		$cpf = preg_replace( '/[^0-9]/is', '', $cpf );
			
		// Verifica se foi informado todos os digitos corretamente
		if (strlen($cpf) != 11) {
			return 2;
		}

		// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
		if (preg_match('/(\d)\1{10}/', $cpf)) {
			return 2;
		}

		// Faz o calculo para validar o CPF
		for ($t = 9; $t < 11; $t++) {
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf[$c] * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf[$c] != $d) {
				return 2;
			}
		}
		
		return 1;				
	} 
	
	// Validar E-mail
	public function validaEmail($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
           return 1;
		} else {
           return 2;
		}
	}

	
   	# Busca CPF cadastrado		
	public function buscaCPFcadastrado($cpf) {
		 // Verifica cpf cadastrado
		 $dados = DB::select('SELECT * FROM indicacao WHERE cpf = :cpf', ['cpf' => $cpf]);
		 if ( $dados ) {
			 return 2;
		 }
	}
	
	# Valida o próximo status da indicação
	public function condicao($id, $status) {
		 $dados = DB::select('SELECT * FROM indicacao WHERE id = :id', ['id' => $id]);

		 $statusgravado = $dados[0]->status_id;
		 if($status == $statusgravado) {
			return 1;
	     } elseif($status==3 and $statusgravado==1) {
			return 2;
		 } elseif($status < $statusgravado) {
			return 3;
		 }

		 return 0;
	}
	
}
