<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\DB;

class IndicacaoController extends Controller {
	
	public function __construct(ValidationController $validacao)   {
        $this->validacao = $validacao;
    }

	# Lista todas as indicações
	public function indicacao() {		
		 $dados = DB::select('SELECT * FROM indicacao');
		 return response()->json($dados);
	}

	# Lista uma indicação buscando pelo ID
	public function showindicacao($id) {		
		 $dados = DB::select('SELECT * FROM indicacao indi INNER JOIN indicacaostatus stat ON indi.status_id=stat.id WHERE indi.id = :id', ['id' => $id]);
		 return response()->json($dados);
	}

	# Lista o status atual de uma indicação buscando pelo ID
	public function showindicacaostatus($id) {		
		 $dados = DB::select('SELECT descricao ultimostatus FROM indicacao indi INNER JOIN indicacaostatus stat ON indi.status_id=stat.id WHERE indi.id = :id', ['id' => $id]);
		 return response()->json($dados);
	}

	# Salva dados de uma indicação
	public function salvar(Request $request) {
		 $dados = $request->all();
		 		 
		 $nome     = $dados['nome'];
		 $cpf      = $dados['cpf'];
		 $telefone = $dados['telefone'];
		 $email    = $dados['email'];
		 
		 // Valida nome vazio
		 if (empty($nome)) {
			return response()->json(['msg'=>'Erro: campo nome vazio.', 'error'=>true]);
		 }
		 
		 // Validando CPF
		 $validaCpf = $this->validacao->validaCPF($cpf);
		 if ($validaCpf==2) {
			return response()->json(['msg'=>'Erro: CPF invalido.', 'error'=>true]);
		 }
		 
		 // Validando e-mail
		 $validaEmail = $this->validacao->validaEmail($email);
		 if ($validaEmail==2) {
			return response()->json(['msg'=>'Erro: Email invalido.', 'error'=>true]);
		 }

		 // Verifica cpf cadastrado
		 $verificaCpf = $this->validacao->buscaCPFcadastrado($cpf);
		 if ($verificaCpf==2) {
			return response()->json(['msg'=>'Erro: CPF cadastrado.', 'error'=>true]);
		 }
		 
		 // Incluir dados
		 $indicacao =  DB::insert('INSERT INTO indicacao (nome, cpf, telefone, email, status_id) VALUES (?, ?, ?, ?, ?)', [$nome, $cpf, $telefone, $email, 1]);
		 
		 return response()->json(['success'=>'Indicacao cadastrada.']);
	}


	# Atualiza status da indicação
	public function status(Request $request) {
		 $dados = $request->all();
		 
		 $id     = $dados['id'];
		 $status = $dados['status_id'];
		 
		 $condicao = $this->validacao->condicao($id, $status);
		 if($condicao==1) {
		 	return ['msg'=>'Erro: Status igual ao gravado.'];
	     } elseif($condicao==2) {
		 	return ['msg'=>'Erro: Status inválido não segue o fluxo.'];
	     } elseif($condicao==3) {
		 	return ['msg'=>'Erro: Status inválido não pode ser menor que o atual.'];
		 }
		 
		 $indicacao =  DB::update('UPDATE indicacao SET status_id = ? WHERE id = ?', [$status, $id]);
		 
		 return response()->json(['success'=>'Status Atualizado.']);
	}

}
