<?php 
session_start();
require_once "class/Solicitacao.php";
require_once "class/Cliente.php";
require_once "class/usuario.php";
//verifica se quem está carregando a pagina tem direito ADM
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo']!=1){
header("location: login.php") ;
exit;
}
$id = filter_input(INPUT_GET,"id", FILTER_VALIDATE_INT);
$solicitacao = new Solicitacao();
$solicitacao->buscarPorId($id);

$cliente = new Cliente();
$cliente->buscarPorId($solicitacao->getClienteId());
$usuario = new Usuario();
$usuario->buscarPorId($cliente->getUsuarioId());
include "includes/header.php";
include "includes/menu.php";
if($_SERVER['REQUEST_METHOD']=== "POST"){
  $resposta = filter_input(INPUT_POST,"resposta", FILTER_UNSAFE_RAW);
  $status = filter_input(INPUT_POST,"status",FILTER_VALIDATE_INT);
  if ($solicitacao->responder($resposta,$status)){
    header("location: admin_solicitacoes.php");
  }


}
?>
<main class="container mt-5">
  <h2>Responder Solicitação #<?= $solicitacao->getId() ?></h2>


    <div class="alert alert-danger"></div>
    <div class="card shadow p-4 mb-4">
      <p><strong>Cliente: </strong><?= $usuario->getNome() ?></p>
         <p><strong>Email: </strong><?= $usuario->getNome() ?></p>
            <p><strong>Endereco: </strong><?= $solicitacao->getEndereco() ?></p>
               <p><strong>Status atual: </strong><?= $solicitacao->getStatus() ?></p>
               <p><strong>Servicos solicitados:</strong></p>
               <ul>
                <?php foreach($solicitacao->servicos as $servico):?>
                  <li><?= $servico['nome'] ?></li>
                <?php endforeach?>
               </ul>
               <p><strong>Descrição do Problema:</strong></p>
               <div class="alert alert-secondary">
                <?= $solicitacao->getDescricaoProblema() ?>
               </div>
    </div>

  <form method="POST" class="bg-light p-4 shadow rounded">

    <div class="mb-3">
      <label class="form-label">Resposta</label>
      <textarea name="resposta" class="form-control" rows="4" required>
        <?= $solicitacao->getDataResposta().'->'.$solicitacao->getRespostaAdmin() ?>
      </textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select" required>
        <option value="1" <?= $solicitacao->getStatus()==1?"selected":"" ?>>Pendente</option>
        <option value="2" <?= $solicitacao->getStatus()==2?"selected":"" ?>>Em Andamento</option>
        <option value="3" <?= $solicitacao->getStatus()==3?"selected":"" ?>>Finalizada</option>
        <option value="4" <?= $solicitacao->getStatus()==4?"selected":"" ?>>Cancelada/option>
        <option value="5" <?= $solicitacao->getStatus()==5?"selected":"" ?>>Recusada</option>
      </select>
    </div>

    <button class="btn btn-success">Salvar</button>
    <a href="admin_solicitacoes.php" class="btn btn-secondary">Cancelar</a>

  </form>
</main>

<?php 
include "includes/footer.php"
?>