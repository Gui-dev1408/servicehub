<?php 
include_once "config/conexao.php";


class Servico {
    // atributos
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $descontinuado;
    private $pdo;

    public function __construct(){
        $this->pdo = obterPdo();
    }

    // Getters / Setters
    public function getId(){
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome(string $nome){
        $this->nome = $nome;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function setDescricao(string $descricao){
        $this->descricao = $descricao;
    }

    public function getPreco(){
        return $this->preco;
    }

    public function setPreco(float $preco){
        $this->preco = $preco;
    }
    public function getDescontinuado(){
        return $this->descontinuado;
    }
    public function setDescontinuado(bool $descontinuado){
        $this->descontinuado = $descontinuado;
}
//metodo inserir
public function inserir(): bool {
    $sql = "INSERT INTO servicos (nome, descricao, preco, descontinuado) 
            VALUES (:nome, :descricao, :preco, :descontinuado)";
    
    $cmd = $this->pdo->prepare($sql);

    $cmd->bindValue(":nome", $this->nome, PDO::PARAM_STR);
    $cmd->bindValue(":descricao", $this->descricao, PDO::PARAM_STR);
    $cmd->bindValue(":preco", $this->preco, PDO::PARAM_STR);
    $cmd->bindValue(":descontinuado", $this->descontinuado, PDO::PARAM_BOOL);

    return $cmd->execute();

}
//metodo atualizar
public function atualizar(): bool { 
    if (!$this->id) return false;

    $sql = "UPDATE servicos 
            SET nome = :nome, 
                descricao = :descricao, 
                preco = :preco, 
                descontinuado = :descontinuado 
            WHERE id = :id";

    $cmd = $this->pdo->prepare($sql);

    $cmd->bindValue(":nome", $this->nome, PDO::PARAM_STR);
    $cmd->bindValue(":descricao", $this->descricao, PDO::PARAM_STR);
    $cmd->bindValue(":preco", $this->preco, PDO::PARAM_STR);
    $cmd->bindValue(":descontinuado", $this->descontinuado, PDO::PARAM_BOOL);
    $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

    return $cmd->execute();
}
//metodo listar
public static function listar(): array {
    $cmd = obterPdo()->query("SELECT * FROM servicos ORDER BY id DESC");
    return $cmd->fetchAll(PDO::FETCH_ASSOC);
}
//metodo listar ativos
public static function listarAtivos(): array {
    $cmd = obterPdo()->query("SELECT * FROM servicos WHERE descontinuado = 0 ORDER BY id DESC");
    return $cmd->fetchAll(PDO::FETCH_ASSOC);
}
//metodo buscar por id
public function buscarPorId(int $id): bool {
    $sql = "SELECT * FROM servicos WHERE id = :id";
    $cmd = $this->pdo->prepare($sql);
    $cmd->bindValue(":id", $id, PDO::PARAM_INT);
    $cmd->execute();

    if ($cmd->rowCount() > 0) {
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        
        // Preenchendo os atributos do objeto atual
        $this->setId($dados['id']);
        $this->setNome($dados['nome']);
        $this->setDescricao($dados['descricao']);
        $this->setPreco($dados['preco']);
        $this->setDescontinuado($dados['descontinuado']);
        
        return true;
    }
    return false;
}
//metodo excluir
public function excluir(): bool {
    if (!$this->id) return false;

    $sql = "DELETE FROM servicos WHERE id = :id";
    $cmd = $this->pdo->prepare($sql);
    $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

    return $cmd->execute();
}
}?>