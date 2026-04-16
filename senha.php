<?php 
// $senha = password_hash("123456", PASSWORD_DEFAULT);
// echo ($senha)

require_once "class/usuario.php";

$usuario = new Usuario();
$usuario->setNome("Milharino Santos");
$usuario->setEmail("mil@harino.sa");
$usuario->setSenha("mi2026@tv");
$usuario->setTipo(2);
if ($usuario->inserir()){
    echo "Usuário ".$usuario->getNome()." inserido com sucesso com o ID: ".$usuario->getId();

}

?>