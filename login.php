<?php 

session_start();//iniciar a sessão ou atualizar uma sessão aberta

// Evita acesso se já estiver logado
if(isset($_SESSION['usuario_id'])){
  $destino = ($_SESSION['tipo'] == 1)?"admin_dashboard.php":"cliente_dashboard.php"; // estrutura do if ternário
  header("location: $destino");
}

require "class/Usuario.php";

$msg = "";
if($_SERVER['REQUEST_METHOD']==="POST"){
  $email = filter_input(INPUT_POST, "email",FILTER_VALIDATE_EMAIL);
  $senha = $_POST["senha"]?? null;
  if(!$email || !$senha ){
    $msg = "Preencha os dados corretamente";
  }
  $usuario = Usuario::efetuarLogin($email, $senha);
  if(count($usuario)>0){
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['tipo'] = $usuario['tipo'];
    
    if($usuario['primeiro_login'] == 1){
      header('location: primeiro_login.php');
      exit;
    }
    if($usuario['tipo']==1){
      header('location: admin_dashboard.php');
    }else{
       header('location: cliente_dashboard.php');
    }

  }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow p-4 col-md-5 mx-auto">
    <h3 class="text-center">Área Restrita</h3>


    <form method="POST">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="senha" class="form-control" required>
      </div>

      <button class="btn btn-dark w-100">Entrar</button>
    </form>

    <p class="text-center mt-3">
      <a href="index.php">Voltar ao site</a>
    </p>
  </div>
</div>
</body>
</html>