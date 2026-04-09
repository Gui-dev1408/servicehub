
<?php
 include 'includes/header.php';
 include 'includes/menu.php';
 
?>

<main class="container mt-5">
  <h2>Painel Administrativo</h2>
  <p>Bem-vindo, </p>

  <a href="admin_solicitacoes.php" class="btn btn-primary">Solicitações</a>
<a href="admin_servicos.php" class="btn btn-warning">Serviços</a>
<a href="logout.php" class="btn btn-danger">Sair</a>
</main>
<!-- Conectar o arquivo footer php -->
<?php   
include 'includes/footer.php';
?>