<?php 
session_start();

require_once "class/Cliente.php";
require_once "class/usuario.php";
require_once "class/Solicitacao.php";
require_once "class/Servico.php";
require_once "class/ServicoSolicitacao.php";

if ($_SERVER['REQUEST_METHOD'] !== "POST"){
    header("location: contratar.php?erro=Requisição inválida.");
    exit();
}

// Verificação de segurança CSRF
$token = $_POST['csrf_token'] ?? "";
// CORREÇÃO: O nome da chave na $_SESSION deve ser 'csrf_token'
if (!$token || !isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    header("location: contratar.php?erro=Falha de segurança CSRF detectada.");
    exit();
}

// Sanitização dos inputs
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$data_preferida = filter_input(INPUT_POST, 'data_preferida', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cpf = preg_replace("/\D/", "", $_POST['cpf'] ?? "");
$servicos_ids = $_POST['servicos_ids'] ?? [];

// Validação dos serviços
if(!is_array($servicos_ids) || count($servicos_ids) < 1){
    header("location: contratar.php?erro=Selecione pelo menos um serviço.");
    exit();
}

$servicos_validos = [];
foreach($servicos_ids as $id){
    $id_validado = filter_var($id, FILTER_VALIDATE_INT);
    if($id_validado) {
        $servicos_validos[] = $id_validado; 
    }
}

// Validações de campos obrigatórios
if (!$nome || strlen($nome) < 3){
    header("location: contratar.php?erro=Nome inválido.");
    exit();
}
if (!$email){
    header("location: contratar.php?erro=E-mail inválido.");
    exit();
}
if (!$telefone || strlen($telefone) < 8){
    header("location: contratar.php?erro=Telefone inválido.");
    exit();
}
if (!$endereco || strlen($endereco) < 5){
    header("location: contratar.php?erro=Endereço inválido.");
    exit();
}
if (!$descricao || strlen($descricao) < 10){
    header("location: contratar.php?erro=Descrição curta demais (mínimo 10 caracteres).");
    exit();
}

// Validação de CPF (se preenchido, deve ter 11 dígitos)
if (!empty($cpf) && strlen($cpf) !== 11){
    header("location: contratar.php?erro=CPF inválido. Digite os 11 números.");
    exit();
}

// Validação da Data
if (!empty($data_preferida)){
    $ts = strtotime($data_preferida);
    if ($ts === false){
        header("location: contratar.php?erro=Data em formato inválido.");
        exit();
    }
    if ($ts < strtotime(date("Y-m-d"))){
        header("location: contratar.php?erro=A data não pode ser anterior a hoje.");
        exit();
    }
}

try {
    // Verificar/Criar Usuário
    $usuarioBanco = new Usuario();
    $existeUsuario = $usuarioBanco->buscarPorEmail($email);
    
    if(!$existeUsuario){
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha(password_hash("123456", PASSWORD_DEFAULT)); // Recomendado usar hash
        $usuario->setTipo(2);
        $usuario->setAtivo(true);
        $usuario->setPrimeiroLogin(true);
        
        if (!$usuario->inserir()){
            throw new Exception("Erro ao cadastrar o Usuário.");
        }
        $usuario_id = $usuario->getId();
    } else {
        $usuario_id = $usuarioBanco->getId();
    }

    // 2. Verificar/Criar Cliente
    $cliente = new Cliente();
    if(!$cliente->buscarPorUsuario($usuario_id)){
        $cliente->setUsuarioId($usuario_id);
        $cliente->setTelefone($telefone);
        $cliente->setCpf($cpf);
        if(!$cliente->inserir()){
            throw new Exception("Erro ao cadastrar o Cliente.");
        }
    }
    $cliente_id = $cliente->getId();

    // 3. Cadastrar Solicitação
    $solicitacao = new Solicitacao();
    $solicitacao->setClienteId($cliente_id);
    $solicitacao->setDescricaoProblema($descricao);
    $solicitacao->setDataPreferida($data_preferida);
    $solicitacao->setEndereco($endereco);
    
    if (!$solicitacao->inserir()){
        throw new Exception("Erro ao cadastrar a Solicitação.");
    }
    $solicitacao_id = $solicitacao->getId();

    // 4. Associar Serviços
    foreach ($servicos_validos as $servico_id) {
        $assoc = new ServicoSolicitacao();
        if (!$assoc->associar($servico_id, $solicitacao_id)) {
            throw new Exception("Erro ao associar serviços.");
        }
    }

    // Sucesso: Redireciona com 'sucesso' (conforme seu HTML espera)
    header("location: contratar.php?sucesso=1");
    exit();

} catch (Exception $e) {
    header("location: contratar.php?erro=" . urlencode($e->getMessage()));
    exit();
}