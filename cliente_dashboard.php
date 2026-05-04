<?php
session_start();
// 1. Verificação de Acesso
if(!isset($_SESSION['usuario_id']) || $_SESSION["tipo"] != 2){
header("location: login.php");
exit();
}
require_once "config/conexao.php";
require_once "class/Solicitacao.php";
$solicitacaoObj = new Solicitacao();
$solicitacoes = $solicitacaoObj->listarPorCliente($_SESSION['usuario_id']);

if (!$solicitacoes) {
$solicitacoes = [];
}

// Verifica se o usuário está logado e se é do tipo "Cliente" (tipo 2)
if (!isset($_SESSION['usuario_id']) || $_SESSION["tipo"] != 2) {
  header("location: login.php");
  exit; // Importante colocar o exit após o header para parar a execução
}

include_once "class/Solicitacao.php";
$solicitacao = new Solicitacao();

// Busca as solicitações filtradas pelo ID do cliente na sessão
$solicitacoes = $solicitacao->listarPorCliente($_SESSION['usuario_id']);

include "includes/header.php";
include "includes/menu.php";
?>

<main class="container mt-5">
  <h2>Bem-vindo, <strong><?= htmlspecialchars($_SESSION['nome']) ?></strong></h2>
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
      <?php foreach ($solicitacoes as $s): ?>
        <tr>
          <td><?= $s['id'] ?></td>
          <td><?= $s['status'] ?></td>

          <td><?= date("d/m/Y H:i", strtotime($s["data_cad"])) ?></td>
          <td>
            <a href="cliente_detalhes.php?id=<?= $s['id'] ?>" class="btn btn-primary btn-sm">Detalhes</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>

<?php include "includes/footer.php"; ?>