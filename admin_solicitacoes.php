
<?php
 include 'includes/header.php';
 include 'includes/menu.php';
 
?>
<main class="container mt-5">
  <h2>Solicitações</h2>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Email</th>
        <th>Status</th>
        <th>Data</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>
            <a href="admin_responder.php?id=" class="btn btn-primary btn-sm">Responder</a>
          </td>
        </tr>
    </tbody>
  </table>

  <a href="admin_dashboard.php" class="btn btn-secondary">Voltar</a>
</main>
<!-- Conectar o arquivo footer php -->
<?php
include 'includes/footer.php';
?>