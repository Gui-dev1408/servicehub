<?php
session_start();
include_once "class/Servico.php";
 include 'includes/header.php';
 if (!isset($_SESSION['csrf_token'])){
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
 }
 include 'includes/menu.php';
 $servicos = Servico::listarAtivos();

 $sucesso =filter_input(INPUT_GET, "sucesso", FILTER_VALIDATE_INT);
$erro = filter_input(INPUT_GET, "erro", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 
?>
<main class="container mt-5">
  <h2 class="text-center mb-4">Contratar Serviço</h2>
  <?php if ($sucesso):?>
    <div class="alert alert-success alert-dismissible fade show">
      Solicitação enviada com sucesso! Em breve entraremos em contato.
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif;?>


    <?php if ($erro):?>
    <div class="alert alert-success alert-dismissible fade show">
      <?= $erro ?>
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif;?>

  <form action="processa_contrato.php" method="POST" class="bg-light p-4 shadow rounded">

    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']?>">

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
        <select name="servicos_ids[]" class="form-select" multiple required size=5>
            <?php foreach($servicos as $servico):?>
            <option value="<?= $servico['id'] ?>">
              <?= $servico['nome'] ?>
            </option>
          <?php endforeach?>
        </select>
        <small class=" text-muted">
        para selecionar mais de um: segure <strong>CTRL</strong>(windows) ou <strong>CMD</strong>(MAC)
     </small> </div>

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