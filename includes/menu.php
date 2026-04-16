<?php 
if(session_status() === PHP_SESSION_NONE)
  session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">ServiceHub</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menuNav">
      <ul class="navbar-nav ms-auto">

        <li class="nav-item"><a class="nav-link" href="index.php#servicos">Serviços</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#diferenciais">Diferenciais</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#testemunhos">Testemunhos</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#clientes">Clientes</a></li>

        <li class="nav-item">
          <a class="btn btn-warning ms-2" href="contratar.php">Contratar</a>
        </li>
            <?php if (isset($_SESSION["usuario_id"])):?>
              <?php if($_SESSION["tipo"] == 1) : ?>
            <li class="nav-item">
              <a class="btn btn-outline-light ms-2" href="admin_dashboard.php">Painel Admin</a>
            </li>
         
            <li class="nav-item">
              <a class="btn btn-outline-light ms-2" href="cliente_dashboard.php">Painel Cliente</a>
            </li>
         <?php endif;?>

          <li class="nav-item">
            <a class="btn btn-danger ms-2" href="logout.php">Sair</a>
          </li>
          <?php else: ?>
        
          <li class="nav-item">
            <a class="btn btn-outline-light ms-2" href="login.php">Login</a>
          </li>

            <?php endif;?>
      </ul>
    </div>
  </div>
</nav>