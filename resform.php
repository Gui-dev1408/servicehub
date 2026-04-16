<?php 

include_once "config/conexao.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    echo " <h3>Chamado pela ação do formulário (POST)</h3> ";
    $id = $_POST['txtid'];
    $sql = "select id, nome from servicos where id = :id";
    $cmd = $pdo->prepare($sql);
    $cmd->execute([':id'=>$id]);
    $serv = $cmd->fetchAll(PDO::FETCH_ASSOC);
    var_dump($serv);
}
if($_SERVER['REQUEST_METHOD']=="GET"){
    echo "<h3>OPA, Chamado pela URL ou formulário method='get'</h3>";
    $idViaGet = $_GET['txtid'];
    $sql = "select * from servicos where id = :id";
    $cmd = $pdo->prepare($sql);
    $cmd->execute([':id'=>$idViaGet]);
    $serviços = $cmd->fetchAll(PDO::FETCH_ASSOC);
    var_dump($serviços);  
}

//var_dump($_SERVER['REQUEST_METHOD']);


?>
