<?php 
include_once "config/conexao.php";

class Cliente {
    // atributos
    private $id;
    private $usuario_id;
    private $telefone;
    private $cpf;
    private $pdo;

    // construtor
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
    public function getClienteId(){
        return $this->usuario_id;
    }
    public function setClienteId(int $usuario_id){
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

    // inserir
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

    // atualizar
    public function atualizar(): bool {
        if (!$this->id) return false;

        $sql = "UPDATE clientes 
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

    // excluir
    public function excluir(): bool {
        if (!$this->id) return false;

        $sql = "DELETE FROM clientes WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }

    // listar todos
    public static function listar(): array {
        $cmd = obterPdo()->query("SELECT * FROM clientes ORDER BY id DESC");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    // buscar por id
    public function buscarPorId(int $id): bool {
        $sql = "SELECT * FROM clientes WHERE id = :id";
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
    //buscar por ususario
    public function buscarPorUsuario(int $usuario_id): bool {
        $sql = "SELECT * FROM clientes WHERE usuario_id = :usuario_id";
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

    // buscar por usuario_id
    public function buscarPorUsuarioId(int $usuario_id): bool {
        $sql = "SELECT * FROM clientes WHERE usuario_id = :usuario_id";
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
}
?>