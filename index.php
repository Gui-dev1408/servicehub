<?php
  include 'includes/header.php';
  include 'includes/menu.php';
?>

<header class="container mt-4">
  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner rounded shadow">
      <div class="carousel-item active">
        <img src="assents/img/banner1.jpg" class="d-block w-100" alt="Banner 1" style="height: 400px; object-fit: cover;">
      </div>
      <div class="carousel-item">
        <img src="assents/img/banner2.jpg" class="d-block w-100" alt="Banner 2" style="height: 400px; object-fit: cover;">
      </div>
      <div class="carousel-item">
        <img src="assents/img/banner3.jpg" class="d-block w-100" alt="Banner 3" style="height: 400px; object-fit: cover;">
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

  <section id="servicos">
    <h2 class="text-center mb-4">Serviços Prestados</h2>
    <div class="row g-4">
      
      <div class="col-md-3">
          <article class="card shadow h-100">
            <div class="card-body">
              <h5>alterar</h5>
              <p></p>
              <p class="fw-bold text-success">R$ 350.00</p>
            </div>
        </article>
      </div>

      </div>
  </section>

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

  <section id="clientes" class="mt-5 text-center">
    <h2 class="mb-4">Principais Clientes</h2>
    <div class="row">
      <div class="col-md-3">Sublime Grace Personalizados</div>
      <div class="col-md-3">Casa Dossica</div>
      <div class="col-md-3">Tilsp Traduções</div>
      <div class="col-md-3">Softkleen Informática</div>
    </div>
  </section>

  <div class="text-center mt-5 mb-5">
    <a href="contratar.php" class="btn btn-lg btn-warning shadow px-5">Solicitar Serviço</a>
  </div>

</main>

<?php
  include 'includes/footer.php';
?>