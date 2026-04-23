<?php
//Teste cliente
require_once "class/Cliente.php";

// ini_set('display_errors',1);

// ini_set('display_startup_erros', 1);

// error_reporting(E_ALL);

// $cliente = new Cliente();

// $cliente ->setUsuarioId(1);

// $cliente ->setTelefone('11987654346');

// $cliente ->setCpf('11122233355');

// if ($cliente->inserir()){

// echo "Cliente com ID: ".$cliente->getId()."<br>Telefone: ".$cliente->getTelefone(). "<br> CPF: " . $cliente->getCpf() . "<br>Inserido Com Sucesso";

// }


 // testando Atualização usando o BuscarPorId

// $cliente = new Cliente();

// $cliente->buscarPorId(1);

// $cliente->setTelefone('11999999999');

// $cliente->setCpf('11122233344');

// if($cliente->atualizar()){

//  echo "Cliente com ID: ".$cliente->getId()."<br>Telefone: ".$cliente->getTelefone(). "<br> CPF: " . $cliente->getCpf() . "<br>Atualizado Com Sucesso";

// }




// testando o metodo listar
// $clientes = Cliente::listar();
// foreach ($clientes as $cliente) {
//     echo "ID: " . $cliente['id'] . "<br>";
//     echo "Usuario ID: " . $cliente['usuario_id'] . "<br>";
//     echo "Telefone: " . $cliente['telefone'] . "<br>";
//     echo "CPF: " . $cliente['cpf'] . "<br><hr>";
// }


//testando o método buscar por id(já foi comprovado que funciona, apenas testando novamente)

// $cliente = new Cliente();

// if($cliente->buscarPorId(2)){

// echo "ID: ".$cliente->getId()."<br>Telefone: ".$cliente->getTelefone(). "<br> CPF: " . $cliente->getCpf() . "<hr>";

// }else{

// echo "Cliente não encontrado.";

// }


// a cima foi feito os testes para a classe cliente, abaixo serão feitos os testes para a classe serviço.




?>
