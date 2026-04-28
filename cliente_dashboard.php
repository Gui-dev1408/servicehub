<?php 
//iniciar a sessão
session_start();
var_dump(function_exists('obterPdo'));
die();
//inclui o arquivo de conexão com o bd
require_once "config/conexao.php";

//inclui funções auxiliares do sistema
require_once "includes/funcoes.php";

//class cliente
require_once "class/Cliente.php";


$pdo = obterPdo();

//verifica se o usuario está logado e se é do tipo cliente 2
if(!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] != 2){
  header("location: login.php"); 
  exit;
}

//cria um objeto da classe cliente
$cliente = new Cliente;

//busca os dados do cliente usando o ID do usuário logado
if(!$cliente->buscarPorId($_SESSION["usuario_id"])){
  //se não encontrar o cliente, encerra a execução
  die("Cliente não encontrado");
}

//consulta sql para buscar as solicitações do cliente
//tambem busca os serviços vinculados a cada solicitação
$sql = "SELECT 
  s.id,
  s.status,
  s.data_cad,
  GROUP_CONCAT(se.nome SEPARATOR ',') AS servicos
FROM solicitacoes s
INNER JOIN ServicoSolicitacoes ss ON ss.solicitacoes_id = s.id
INNER JOIN servicos se ON se.id = ss.servico_id
WHERE s.cliente_id=?
GROUP BY s.id, s.status, s.data_cad
ORDER BY s.data_cad DESC";

//prepara a consulta 
$stmt = $pdo->prepare($sql);

//execute
$stmt->execute([$cliente->getId()]);

//busca todas as solicitções encontradas no banco
$solicitacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "includes/header.php";
include "includes/menu.php";
?>

<main class="container mt-5">
  <h2>Bem-vindo,</h2>
  <p><a href="logout.php" class="btn btn-danger btn-sm">Sair</a></p>
  <a href="cliente_perfil.php" class="btn btn-warning btn-sm">Meu Perfil</a>

  <h4 class="mt-4">Minhas Solicitações</h4>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Serviços</th>
        <th>Status</th>
        <th>Data</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
      
    <!-- Percorre todas as solicitações retornadas no banco -->
    <?php foreach($solicitacoes as $s): ?>
      <tr>

        <!-- Exibe o id da solicitção -->
        <td><?= $s["id"] ?></td>

        <td>
          <?php 
          //Divide a lista de servicos em um array
          $lista = explode(",", $s["servicos"]);

          //percorre cada servico da solicitação 
          foreach ($lista as $nomeServicos):

            //htmlspecialchars evita execução de codigo html/js malicioso
            echo '<span class="badge bg-primary me-1 mb-1">' .
            htmlspecialchars($nomeServicos) . '</span>';

          endforeach;
          ?>
        </td>

        <td>
          <!-- exibe o status em formato de texto usando função-->
          <?php statusTexto($s["status"]); ?>
        </td>

        <td>
          <!--formata data para padrao brasileiro-->
          <?= date("d/m/Y H:i", strtotime($s["data_cad"])) ?>
        </td>

        <td>
          <a href="cliente_detalhes.php?id=<?= $s["id"] ?>" class="btn btn-primary btn-sm">
            Detalhes
          </a>
        </td>

      </tr>
    <?php endforeach; ?>

    </tbody>
  </table>
</main>

<!-- Conectar o arquivo footer php -->
<?php
include 'includes/footer.php';
?>