
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Primeiro Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow p-4 col-md-5 mx-auto">
    <h3 class="text-center mb-3">Primeiro Login</h3>

    <p class="text-center text-muted">
      Por segurança, altere sua senha para continuar.
    </p>




    <form method="POST">

      <div class="mb-3">
        <label class="form-label">Senha Atual</label>
        <input type="password" name="senha_atual" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Nova Senha</label>
        <input type="password" name="nova_senha" class="form-control" required minlength="6">
      </div>

      <div class="mb-3">
        <label class="form-label">Confirmar Nova Senha</label>
        <input type="password" name="confirmar_senha" class="form-control" required minlength="6">
      </div>

      <button class="btn btn-primary w-100">Salvar Nova Senha</button>
    </form>

    <div class="text-center mt-3">
      <a href="logout.php">Cancelar e sair</a>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>