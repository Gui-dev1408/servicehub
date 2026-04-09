<?php
 include 'includes/header.php';
 include 'includes/menu.php';   
 ?>

<main class="container mt-5">
  <h2>Bem-vindo,</h2>
  <p><a href="logout.php" class="btn btn-danger btn-sm">Sair</a></p>
  <a href="cliente_perfil.php" class="btn btn-warning btn-sm">Meu Perfil</a>
  <h4 class="mt-4">Minhas Solicitações</h4>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Status</th>
        <th>Data</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
   
          <td></td>
         
          <td></td>
          <td></td>
          <td>
            <a href="cliente_detalhes.php?id=" class="btn btn-primary btn-sm">Detalhes</a>
          </td>
        </tr>
    </tbody>
  </table>
</main>
<!-- Conectar o arquivo footer php -->
<?php
include 'includes/footer.php';
?>