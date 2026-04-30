<?php // Verificar se o usuário está logado e é admin
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION["tipo"] != 1) {
    header("location: login.php");
}
// aqui vamos buscar os serviços para exibir na tela
include_once "config/conexao.php";
include_once "class/Servico.php";
// aqui vamos buscar os serviços para exibir na tela
include "includes/header.php";
include "includes/menu.php";
// obtendo os serviços para exibir na tela
$pdo = obterPdo();
$sql = "select * from servicos";
$cmd = obterPdo()->prepare($sql);
$cmd->execute();
$servicos = $cmd->fetchAll(PDO::FETCH_ASSOC);
// print_r($servicos); // aqui vamos exibir os serviços em uma tabela 
?> <main class="container mt-5">
    <h2>Serviços Cadastrados</h2> <a href="formservico.php" class="btn btn-primary mb-3">Adicionar Serviço</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
            </tr>
        </thead>
        <tbody> <?php foreach ($servicos as $s): ?> <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= $s['nome'] ?></td>
                    <td><?= $s['descricao'] ?></td>
                    <td><?= number_format($s['preco'], 2, ",", ".") ?></td>
                </tr> <?php endforeach; ?> </tbody>
    </table> <a href="admin_dashboard.php" class="btn btn-secondary">Voltar</a>
</main> <?php include "includes/footer.php"; ?>