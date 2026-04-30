<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "class/Solicitacao.php";

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo']!=1){
  header("Location: login.php");
  exit;
}
$solicitacoes = Solicitacao::listar();

include "includes/header.php";
include "includes/menu.php";
?>

<main class="container mt-5">
  <h2>Solicitações</h2>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Email</th>
        <th>Serviços</th>
        <th>Status</th>
        <th>Data</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($solicitacoes as $s):?>
        <tr>
          <td><?= $s['id']  ?></td>
          <td><?= $s['cliente_nome'] ?></td>
          <td><?= $s['cliente_email'] ?></td>
          <td>
            <?php 
              $lista = explode(", ", $s['servicos']);
              foreach($lista as $serv){
                echo '<span class="badge bg-secondary me-1 mb-1">'.$serv.'</span>'; 
              }
            ?>
          </td>
          <td><?= $s['status'] ?></td>
          <td><?= date("d/m/Y H:i", strtotime($s["data_cad"])) ?></td>
          <td>
            <a href="admin_responder.php?id=" class="btn btn-primary btn-sm">Responder</a>
          </td>
        </tr>
        <?php endforeach;?>
    </tbody>
  </table>

  <a href="admin_dashboard.php" class="btn btn-secondary">Voltar</a>
</main>

<?php 
include "includes/footer.php";
?>

