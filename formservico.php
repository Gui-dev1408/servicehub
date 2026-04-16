<?php  
 
require_once "config/conexao.php";// não muda
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
if($_SERVER['REQUEST_METHOD']=="POST"){
    $nome = $_POST['txtnome'];
    $descricao = $_POST['txtdescricao'];
    $preco = $_POST['txtpreco'];
 
     
    $sql = "insert servicos (nome, descricao, preco) values(:nome, :descricao, :preco)";
    $cmd = obterPdo()->prepare($sql);
    $cmd->execute([':nome'=>$nome, ':descricao'=>$descricao, ':preco'=>$preco]);
    $id = $pdo->lastInsertId();
 
    if(isset($id)){
        echo "Serviço cadastrado com Sucesso, com o ID ".$id;
    }else{
        echo "Falha ao cadastrar o serviço";
    }
}
 
$sql = "select * from servicos";
$cmd = obterPdo()->prepare($sql);
$cmd->execute();
$servicos = $cmd->fetchAll(PDO::FETCH_ASSOC);
 
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Formulário de Cadastro de Serviços</title>
</head>
<body>
<form action="formservico.php" method="post">
<input type="number" name="txtid" hidden>
<label for="txtnome">Nome</label>
<input type="text" name="txtnome" >
<label for="txtdescricao">Descrição</label>
<input type="text" name="txtdescricao">
<label for="txtpreco">Preço</label>
<input type="text" name="txtpreco">
<button type="submit">Gravar</button>
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
</body>
</html>