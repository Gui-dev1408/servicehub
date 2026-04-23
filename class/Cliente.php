<?php 
include_once "config/conexao.php";

class Cliente {
    // atributos
    private $id;
    private $usuario_id;
    private $telefone;
    private $cpf;
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

    public function getUsuarioId(){
        return $this->usuario_id;
    }

    public function setUsuarioId(int $usuario_id){
        $this->usuario_id = $usuario_id;
    }

    public function getTelefone(){
        return $this->telefone;
    }

    public function setTelefone(string $telefone){
        $this->telefone = $telefone;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function setCpf(string $cpf){
        $this->cpf = $cpf;
    }

    // metodo inserir
    public function inserir(): bool {
        $sql = "INSERT INTO clientes (usuario_id, telefone, cpf) 
                VALUES (:usuario_id, :telefone, :cpf)";
        
        $cmd = $this->pdo->prepare($sql);

        $cmd->bindValue(":usuario_id", $this->usuario_id, PDO::PARAM_INT);
        $cmd->bindValue(":telefone", $this->telefone, PDO::PARAM_STR);
        $cmd->bindValue(":cpf", $this->cpf, PDO::PARAM_STR);

        if ($cmd->execute()) {
            $this->id = $this->pdo->lastInsertId();
            return true;
        }

        return false;
    }

    // metodo atualizar
    public function atualizar(): bool {
        if (!$this->id) return false;

        $sql = "UPDATE cliente 
                SET usuario_id = :usuario_id, 
                    telefone = :telefone, 
                    cpf = :cpf 
                WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);

        $cmd->bindValue(":usuario_id", $this->usuario_id, PDO::PARAM_INT);
        $cmd->bindValue(":telefone", $this->telefone, PDO::PARAM_STR);
        $cmd->bindValue(":cpf", $this->cpf, PDO::PARAM_STR);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }

    // metodo listar
    public static function listar(): array {
        $cmd = obterPdo()->query("SELECT * FROM cliente ORDER BY id DESC");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo listar ativos
    public static function listarAtivos(): array {
        $cmd = obterPdo()->query("SELECT * FROM cliente WHERE ativo = 1 ORDER BY id DESC");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo buscar por id
    public function buscarPorId(int $id): bool {
        $sql = "SELECT * FROM cliente WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);
        $cmd->execute();

        if ($cmd->rowCount() > 0) {
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            $this->setId($dados['id']);
            $this->setUsuarioId($dados['usuario_id']);
            $this->setTelefone($dados['telefone']);
            $this->setCpf($dados['cpf']);
            return true;
        }
        return false;
}
//metodo buscar por usuario_id
public function buscarPorUsuarioId(int $usuario_id): bool {
    $sql = "SELECT * FROM cliente WHERE usuario_id = :usuario_id";
    $cmd = $this->pdo->prepare($sql);
    $cmd->bindValue(":usuario_id", $usuario_id, PDO::PARAM_INT);
    $cmd->execute();

    if ($cmd->rowCount() > 0) {
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        $this->setId($dados['id']);
        $this->setUsuarioId($dados['usuario_id']);
        $this->setTelefone($dados['telefone']);
        $this->setCpf($dados['cpf']);
        return true;
    }
    return false;
}

}?>