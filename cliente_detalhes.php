<?php
session_start();
include_once "config/conexao.php";
include_once "includes/funcoes.php";
 include 'includes/header.php';
 include 'includes/menu.php';   
 ?>


<main class="container mt-5">
  <h3>Solicitação #</h3>

  <p><strong>Status:</strong> </p>
  <p><strong>Descrição:</strong> </p>
  <p><strong>Endereço:</strong> </p>
<p><strong>Serviços Solicitados:</strong> </p>
<p><strong>Descrição do Problema:</strong> </p>
 
    <div class="alert alert-info">
      <strong>Resposta do Admin:</strong><br>
      
    </div>
 
    <div class="alert alert-warning">Ainda não há resposta.</div>
  

  <a href="cliente_dashboard.php" class="btn btn-secondary">Voltar</a>
</main>
<!-- Conectar o arquivo footer php -->
<?php                       
include 'includes/footer.php';
?>