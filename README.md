# api-indicacao
Feito em laravel e eu sem nenhum conhecimento. 
Do Larave, usei basimente o recurso de rotas, mas a maior parte do script foi PHP puro mesmo e POSTGRESQL.

Implementar uma API para sistema de indicações.
# TAREFAS
    IMPLEMENTAÇÃO DA API COM FRAMEWORK (LARAVEL)
    CRIAÇÃO DA ESTRUTURA DO BANCO DE DADOS (POSTGRESQL)
    VALIDAÇÃO DE CPF E EMAIL
    CPF NÃO PODE SER INDICADO MAIS DE UMA VEZ

# ESTRUTURA DO BANCO
    INDICAÇÕES: ID, NOME, CPF, TELEFONE, EMAIL, STATUS_ID
    STATUS DAS INDICAÇÕES: ID, DESCRIÇÃO [1. INICIADA / 2. FINALIZADA / 3. EM PROCESSO]

# FUNCIONALIDADES
    LISTAR 
    INCLUIR (STATUS INICIAL = INICIADA)
    EVOLUIR STATUS (precisa seguir o fluxo Iniciada -> Em processo -> Finalizada)

Por se tratar de uma API, não é necessário a implementação de telas para a solução.

-----
# APLICAÇÕES USADAS NO DESENVOLVIMENTO
  Foi usado como base o Bitnami com Apache, PHP, Postgresql e Laravel
# TESTES
   Foi usado o POSTMAN para realização dos testes da API

