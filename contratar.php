<?php
 include 'includes/header.php';
 include 'includes/menu.php';
 
?>
<main class="container mt-5">
  <h2 class="text-center mb-4">Contratar Serviço</h2>
  <form action="processa_contrato.php" method="POST" class="bg-light p-4 shadow rounded">

    <input type="hidden" name="csrf_token" value="">

    <div class="row">

      <div class="col-md-6 mb-3">
        <label class="form-label">Nome Completo</label>
        <input type="text" name="nome" class="form-control" required minlength="3">
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">Telefone</label>
        <input type="text" name="telefone" class="form-control" required minlength="8" maxlength="20">
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">CPF (opcional)</label>
        <input type="text" name="cpf" class="form-control" minlength="11" maxlength="14">
      </div>

      <div class="col-md-12 mb-3">
        <label class="form-label">Endereço</label>
        <input type="text" name="endereco" class="form-control" required minlength="5">
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">Data Preferida (opcional)</label>
        <input type="date" name="data_preferida" class="form-control">
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">Serviço</label>
        <select name="servico_id" class="form-select" required>
          <option value="">Selecione...</option>
     
            <option value="">
           
            </option>
         
        </select>
      </div>

      <div class="col-md-12 mb-3">
        <label class="form-label">Descrição do Problema</label>
        <textarea name="descricao" class="form-control" rows="4" required minlength="10"></textarea>
      </div>

    </div>

    <button class="btn btn-success w-100">Enviar Solicitação</button>
  </form>
</main>
<?php
include 'includes/footer.php';
?>