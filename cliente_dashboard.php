<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION["tipo"]!=2){
  header("location: login.php");
}
// aqui vamos buscar as solicitações do cliente logado
include_once "class/Solicitacao.php";
$solicitacao = new Solicitacao();
// o método listarPorCliente vai retornar as solicitações do cliente logado, usando o id do usuário que está na sessão
$solicitacoes = $solicitacao->listarPorCliente($_SESSION['usuario_id']);
 
include "includes/header.php";
include "includes/menu.php";
 
?>
 
<main class="container mt-5">
  <h2>Bem-vindo, <strong><?= $_SESSION['nome'] ?></strong></h2>
  <p><a href="logout.php" class="btn btn-danger btn-sm">Sair</a></p>
  <a href="cliente_perfil.php" class="btn btn-warning btn-sm">Meu Perfil</a>
  <h4 class="mt-4">Minhas Solicitações</h4>
 
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Status</th>
        <th>Data</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($solicitacoes as $s):?>
        <tr>
          <td><?= $s['id'] ?></td>
          <td><?= $s['status'] ?></td>
          <td><?= $s[ date("d/m/Y H:i", strtotime($s["data_cad"])) ] ?></td>
          <td>
            <a href="cliente_detalhes.php?id=<?= $s['id'] ?>" class="btn btn-primary btn-sm">Detalhes</a>
          </td>
        </tr>
        <?php endforeach;?>
    </tbody>
  </table>
</main>
 
<?php
include "includes/footer.php";
?>