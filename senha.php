<?php 
// $senha = password_hash("123456", PASSWORD_DEFAULT);
// echo ($senha);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "class/usuario.php";
//Testando update
// $usuario = new Usuario();
// if($usuario->buscarPorId(62)){
//     echo "<pre>";
//     print_r($usuario);
// }
// else{
//     echo "Usuário não encontrado";
// die();
// }
// $usuario->setNome("Milhonario Santos");
// echo "<hr>";
// echo "<pre>";
// if($usuario->atualizar())
//     print_r($usuario);

$usuario = new Usuario();
($usuario->buscarPorId(62));
if($usuario->atualizarSenha("123456",PASSWORD_DEFAULT))
    echo "Senha do Usuario " .$usuario->getNome()." Atualizada com sucesso!"
?>