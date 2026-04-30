<?php 
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !=1)
  header("location: login.php");

include "includes/header.php";
include "includes/menu.php";
?>

<main class="container mt-5">
  <h2>Painel Administrativo</h2>
  <p>Bem-vindo, <strong><?=  $_SESSION['nome']?></strong> </p>

  <a href="admin_solicitacoes.php" class="btn btn-primary">Solicitações</a>
<a href="admin_servicos.php" class="btn btn-warning">Serviços</a>
<a href="logout.php" class="btn btn-danger">Sair</a>
</main>






