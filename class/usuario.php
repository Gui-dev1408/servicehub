<?php 
// incluir a conexão
include_once "config/conexao.php";
// declara a classe
class Usuario{
    // atributos
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tipo;
    private $ativo;
    private $primeiro_login;
    private $pdo;
    // construtores
    public function __construct(){
       $this->pdo = obterPdo();
    }
    // Getters / Setters
    public function getId(){
        return $this->id;
    }
    public function getNome(){
        return $this->nome;
    }
    public function setNome(string $nome){
        $this->nome = $nome;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail(string $email){
        $this->email = $email;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function setSenha(string $senha){
        $this->senha = $senha;
    }
    public function getTipo(){
        return $this->tipo;
    }
    public function setTipo(string $tipo){
        $this->tipo = $tipo;
    }
    public function getAtivo(){
        return $this->ativo;
    }
    public function setAtivo(string $ativo){
        $this->ativo = $ativo;
    }
    public function getPrimeiroLogin(){
        return $this->primeiro_login;
    }
    public function setPrimeiroLogin(string $primeiro_login){
        $this->ativo = $primeiro_login;
    }
    // métodos (functions)  - Representam os RFs do projeto
    // efetuar login
    public static function efetuarLogin(string $email, string $senha):array{
        $sql = "select * from usuarios where email = :email and ativo = b'1'";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":email", $email);
        $cmd->execute();
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        if($dados && password_verify($senha, $dados['senha'])){
            return $dados;
        }else{
            return $dados = [];    
        }
    }
 
    //Inserir
    public function inserir():bool{
        
        $sql ="INSERT usuarios (nome, email, senha, tipo)
        
            values(:nome, :email, :senha, :tipo)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":nome", $this->nome);
        $cmd->bindValue(":email", $this->email);
        $cmd->bindValue(":senha", password_hash($this->senha, PASSWORD_DEFAULT));
        $cmd->bindValue(":tipo", $this->tipo);
if ($cmd->execute()){
        $this->id = $this->pdo->lastInsertId();
   return true;
    }
      return false;  
    }
    
 
}