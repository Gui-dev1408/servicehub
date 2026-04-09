

<main class="container mt-5">
  <h2>Meu Perfil</h2>


  <div class="card shadow p-4">

    <p><strong>Nome:</strong> </p>
    <p><strong>Email:</strong> </p>

    <form method="POST">

      <div class="mb-3">
        <label class="form-label">Telefone</label>
        <input type="text" name="telefone" class="form-control"
               value="">
      </div>

      <hr>

      <h5>Alterar Senha</h5>

      <div class="mb-3">
        <label class="form-label">Senha Atual</label>
        <input type="password" name="senha_atual" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Nova Senha</label>
        <input type="password" name="nova_senha" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Confirmar Nova Senha</label>
        <input type="password" name="confirmar" class="form-control">
      </div>

      <button class="btn btn-primary">Salvar Alterações</button>
      <a href="cliente_dashboard.php" class="btn btn-secondary">Voltar</a>

    </form>

  </div>
</main>
