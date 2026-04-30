<?php 
session_start();

require_once "class/Cliente.php";
require_once "class/usuario.php";
require_once "class/Solicitacao.php";
require_once "class/Servico.php";
require_once "class/ServicoSolicitacao.php";

if ($_SERVER['REQUEST_METHOD'] !=="POST"){
    header("location: contratar.php?erro=Invalid Request.");
    exit();
}

//verificação de segurança (se quem ta logado tem direito de carregar esta pagina)
//csrf
$token =$_POST ['csrf_token']??"";
if (!$token || !isset($_SESSION['crsf_token']) || $token !== $_SESSION['csrf_token']){
    header("location: contratar.php?erro=falha de segurança CSRF detectada");
    exit();
}
//inputs são os capos do formulario
$nome = filter_input(INPUT_POST,'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL );
$telefone = filter_input(INPUT_POST,'telefone', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

$endereco = filter_input(INPUT_POST,'endereco', FILTER_UNSAFE_RAW);
$descricao = filter_input(INPUT_POST,'descricao', FILTER_UNSAFE_RAW);

$data_preferida = filter_input(INPUT_POST,'data_preferida', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

$cpf = preg_replace("/\D/", "", $_POST['cpf'] ?? "");
$servicos_ids = $_POST['servicos_ids'] ?? []; //array de serviços

//validação dos serviços
if(!is_array($servicos_ids)){
header("location: contratar.php?erro=Selecione pelo menos um serviço.");
    exit();
}
$servicos_validos =[];
foreach($servicos_ids as $id){
    $id = filter_var($id, FILTER_VALIDATE_INT);
   $servicos_validos[] = $id; 
}
//validações gerais
if (!$nome || strlen($nome) < 3){
    header("location: contratar.php?erro=Nome invalido.");
    exit();
}
if (!$email){
    header("location: contratar.php?erro=Email invalido.");
    exit();
}
if (!$telefone || strlen($telefone) < 8){
    header("location: contratar.php?erro=Telefone invalido.");
    exit();
}
if (!$endereco || strlen($endereco) < 5){
    header("location: contratar.php?erro=Endereço invalido.");
    exit();
}
if (!$descricao || strlen($descricao) < 10){
    header("location: contratar.php?erro=Descrição do problema invalida. (Mínimo 10 caracteres).");
    exit();
}
if (!$cpf && strlen($cpf) !== 11){
    header("location: contratar.php?erro=CPF invalido. Digite 11 numeros).");
    exit();
}
if (count($servicos_validos) < 1){
header("location: contratar.php?erro=Selecione pelo menos um serviço valido.");
    exit();
}
if ($data_preferida ){
    $ts = strtotime($data_preferida);
    if (!$ts === false){
        header("location: contratar.php?erro=Data invalida.");
        exit();
    }
    if ($ts < strtotime(date("Y-m-d"))){
        header("location: contratar.php?erro=A data não pode ser anterior à data atual.");
        exit();
    }
}
try{



//verificar se usuario já existe 
$usuarioBanco = new Usuario();
if($usuarioBanco->buscarPorEmail($email)==false){


$usuario = new Usuario();
$usuario->setNome($nome);
$usuario->setEmail($email);
$usuario->setSenha("123456");
$usuario->setTipo(2);
$usuario->setAtivo(true);
$usuario->setPrimeiroLogin(true);
if (!$usuario->inserir()){
    header("location: contratar.php?erro=Erro ao cadastrar o Usuário.");
    exit();
    }
    $usuario_id = $usuario->getId();
}else{
    $usuario_id = $usuarioBanco->getId();
}
// verificar se cliente já existe
$cliente = new Cliente();
if($cliente->buscarPorUsuario($usuario_id)==false){
//gravamos o cliente
$cliente->setUsuarioId($usuario_id);
$cliente->setTelefone($telefone);
$cliente->setCpf($cpf);
if(!$cliente->inserir()){
    header("location: contratar.php?erro=Erro ao cadastrar o Cliente.");
    exit();
    }
}
$cliente_id = $cliente->getId();
//cadastrar a solicitação:
$solicitacao = new Solicitacao();
$solicitacao->setClienteId($cliente_id);
$solicitacao->setDescricaoProblema($descricao);
$solicitacao->setDataPreferida($data_preferida);
$solicitacao->setEndereco($endereco);
if (!$solicitacao->inserir()){
    header("location: contratar.php?erro=Erro ao cadastrar a Solicitação.");
    exit();
}
$solicitacao_id = $solicitacao->getId();

//Associar os serviços a solicitação

foreach ($servicos_validos as $servico_id) {
$assoc = new ServicoSolicitacao();
$assoc->setServicoId($servico_id);
$assoc->setSolicitacaoId($solicitacao_id);
if (!$assoc->associar($servico_id,$solicitacao_id)) {
header("location: contratar.php?erro=Erro ao associar serviços à solicitação.");
exit();
}

}
header("location: contratar.php?success=1");
} catch (Exception $e) {
header("location: contratar.php?erro=Erro ao processar solicitação: " . $e->getMessage());
exit();
}

