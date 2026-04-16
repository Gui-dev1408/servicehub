<?php 
include_once "config/conexao.php";



$id = 22;
$sql = "select * from servicos where id = :id";
$cmd = $pdo->prepare($sql,);
$cmd->execute([":id"=>$id]);
$serv = $cmd->fetch(PDO::FETCH_ASSOC);
if($serv){
    var_dump($serv);
}else{
    echo "Serviço com id ".$id." não encontrado";
}



$sql = "select * from servicos";
$cmd = $pdo->prepare($sql);
$cmd->execute();
$servicos = $cmd->fetchAll(PDO::FETCH_ASSOC);

$sql = "select * from usuarios";
$cmd = $pdo->prepare($sql);
$cmd->execute();

$usuarios = $cmd->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Aula PDO PHP</title>
</head>
<body>


    <form action="resform.php" method="post">
        <input type="text" name="txtid" id="">    
        <button type="submit">Enviar</button>
    </form>



    <h2>Lista de Serviços</h2>
    <table border="1" cellpadding = 10>
        <tr>
           <th>ID</th>
           <th>Nome</th>
           <th>Descrição</th>
           <th>Preço</th>
           <th>Descontinuado</th> 
        </tr>
        <?php foreach($servicos as $servico): ?>
        <tr>
            <td><?= $servico['id']?></td>
            <td><?= $servico['nome']?></td>
            <td><?= $servico['descricao']?></td>
            <td><?= $servico['preco']?></td>
            <td><?= $servico['descontinuado']?"Sim":"Não"   ?></td>
        </tr>
        <?php endforeach; ?>
    </table>


    <h2>Lista de Usuários</h2>
    <table border="1" cellpadding = 10>
        <tr>
           <th>ID</th>
           <th>Nome</th>
           <th>Email</th>
           <th>Tipo</th>
           <th>Descontinuado</th> 
        </tr>
        <?php foreach($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['id']?></td>
            <td><?= $usuario['nome']?></td>
            <td><?= $usuario['email']?></td>
            <td><?= $usuario['tipo']?></td>
            <td><?= $usuario['ativo']?"Sim":"Não"   ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <hr>




</body>
</html>







