<?php
require_once "config/conexao.php";

// conexão única (melhor prática)
$pdo = obterPdo();

// ===== Serviços =====
$cmd = $pdo->prepare("SELECT * FROM servicos WHERE descontinuado = b'0'");
$cmd->execute();
$serv = $cmd->fetchAll(PDO::FETCH_ASSOC);

// ===== Clientes =====
$sql = "SELECT nome FROM usuarios WHERE tipo = 2 AND ativo = 1 ORDER BY id ASC LIMIT 4";
$cmd = $pdo->prepare($sql);
$cmd->execute();
$clientes = $cmd->fetchAll(PDO::FETCH_ASSOC);

include "includes/menu.php";
include "includes/header.php";
?>

<header class="container mt-4">

  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    
    <div class="carousel-inner rounded shadow">

      <div class="carousel-item active">
        <img src="assets/img/banner1.jpg" class="d-block w-100 banner-img" alt="Banner 1">
      </div>

      <div class="carousel-item">
        <img src="assets/img/banner2.jpg" class="d-block w-100 banner-img" alt="Banner 2">
      </div>

      <div class="carousel-item">
        <img src="assets/img/banner3.jpg" class="d-block w-100 banner-img" alt="Banner 3">
      </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>

  </div>

</header>

<main class="container mt-5">

  <!-- ===== SERVIÇOS ===== -->
  <section id="servicos">

    <h2 class="text-center mb-4">Serviços Prestados</h2>

    <div class="row g-4">

      <?php foreach ($serv as $servico): ?>
        <div class="col-md-3">
          <article class="card shadow h-100">
            <div class="card-body">

              <h5><?= htmlspecialchars($servico['nome']) ?></h5>

              <p><?= htmlspecialchars($servico['descricao']) ?></p>

              <p class="fw-bold text-success">
                R$ <?= number_format($servico['preco'], 2, ',', '.') ?>
              </p>

            </div>
          </article>
        </div>
      <?php endforeach; ?>

    </div>
  </section>

  <!-- ===== DIFERENCIAIS ===== -->
  <section id="diferenciais" class="mt-5">

    <h2 class="text-center mb-4">Nossos Diferenciais</h2>

    <div class="row text-center">

      <div class="col-md-4">
        <h5>Atendimento Rápido</h5>
        <p>Agendamento rápido e execução eficiente.</p>
      </div>

      <div class="col-md-4">
        <h5>Equipe Qualificada</h5>
        <p>Técnicos especializados e atualizados.</p>
      </div>

      <div class="col-md-4">
        <h5>Garantia</h5>
        <p>Serviços com garantia e suporte pós atendimento.</p>
      </div>

    </div>
  </section>

  <!-- ===== TESTEMUNHOS ===== -->
  <section id="testemunhos" class="mt-5">

    <h2 class="text-center mb-4">Testemunhos</h2>

    <div class="row">

      <div class="col-md-4">
        <blockquote class="p-3 bg-light shadow rounded">
          "Serviço excelente! Resolveram meu problema rápido."
          <footer class="mt-2 fw-bold">- Ana Souza</footer>
        </blockquote>
      </div>

      <div class="col-md-4">
        <blockquote class="p-3 bg-light shadow rounded">
          "Equipe muito profissional, recomendo!"
          <footer class="mt-2 fw-bold">- Carlos Lima</footer>
        </blockquote>
      </div>

      <div class="col-md-4">
        <blockquote class="p-3 bg-light shadow rounded">
          "Preço justo e atendimento impecável."
          <footer class="mt-2 fw-bold">- Fernanda Rocha</footer>
        </blockquote>
      </div>

    </div>
  </section>

  <!-- ===== CLIENTES ===== -->
  <section id="clientes" class="mt-5 bg-light pb-5">

    <h2 class="text-center mb-4">Principais Clientes</h2>

    <div class="row text-center">

      <?php if (!empty($clientes)): ?>
        <?php foreach ($clientes as $cliente): ?>
          <div class="col-md-3">
            <?= htmlspecialchars($cliente['nome']) ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center">Nenhum cliente encontrado.</p>
      <?php endif; ?>

    </div>

  </section>

  <!-- ===== BOTÃO ===== -->
  <div class="text-center mt-5">
    <a href="contratar.php" class="btn btn-lg btn-warning">
      Solicitar Serviço
    </a>
  </div>

</main>

<?php include "includes/footer.php"; ?>