<?php
 include 'includes/header.php';
 include 'includes/menu.php';
 
?>

<main class="container mt-5">
  <h2>Responder Solicitação #</h2>


    <div class="alert alert-danger"></div>


  <form method="POST" class="bg-light p-4 shadow rounded">

    <div class="mb-3">
      <label class="form-label">Resposta</label>
      <textarea name="resposta" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select" required>
        <option value="2">Em andamento</option>
        <option value="3">Finalizada</option>
        <option value="5">Recusada</option>
      </select>
    </div>

    <button class="btn btn-success">Salvar</button>
    <a href="admin_solicitacoes.php" class="btn btn-secondary">Cancelar</a>

  </form>
</main>
<!-- Conectar o arquivo footer php -->
<?php
include 'includes/footer.php';
?>