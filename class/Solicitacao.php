<?php
include_once "config/conexao.php";

class Solicitacao {

    private $id;
    private $cliente_id;
    private $descricao_problema;
    private $data_preferida;
    private $status;
    private $data_cad;
    private $data_atualizacao;
    private $data_resposta;
    private $resposta_admin;
    private $endereco;
    private $pdo;

    public function __construct() {
        $this->pdo = obterPdo();
    }

    public function getId() {
        return $this->id;
    }

    public function setClienteId(int $cliente_id) {
        $this->cliente_id = $cliente_id;
    }

    public function setDescricaoProblema(string $descricao) {
        $this->descricao_problema = $descricao;
    }

    public function setDataPreferida($data) {
        $this->data_preferida = $data;
    }

    public function setEndereco(string $endereco) {
        $this->endereco = $endereco;
    }

    public function inserir(): bool {
        $sql = "INSERT INTO solicitacoes (cliente_id, descricao_problema, data_preferida, status, endereco)
                VALUES (:cliente_id, :descricao, :data_preferida, 1, :endereco)";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":cliente_id", $this->cliente_id, PDO::PARAM_INT);
        $cmd->bindValue(":descricao", $this->descricao_problema);
        $cmd->bindValue(":data_preferida", $this->data_preferida);
        $cmd->bindValue(":endereco", $this->endereco);

        if ($cmd->execute()) {
            $this->id = $this->pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public static function listar(): array {
          $sql = "SELECT s.id, s.status, s.data_cad,
            u.nome AS cliente_nome,
            u.email AS cliente_email,
            GROUP_CONCAT(se.nome SEPARATOR ', ') AS servicos
    FROM solicitacoes s
    INNER JOIN clientes c ON c.id = s.cliente_id
    INNER JOIN usuarios u ON u.id = c.usuario_id
    INNER JOIN servico_solicitacao ss ON ss.solicitacao_id = s.id
    INNER JOIN servicos se ON se.id = ss.servico_id
    GROUP BY s.id, s.status, s.data_cad, u.nome, u.email
    ORDER BY s.data_cad DESC";

        $cmd = obterPdo()->query($sql);
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorCliente(int $cliente_id): array {
        $sql = "SELECT * FROM solicitacoes WHERE cliente_id = :cliente_id ORDER BY data_cad DESC";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":cliente_id", $cliente_id, PDO::PARAM_INT);
        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id): bool {
        $sql = "SELECT * FROM solicitacoes WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);
        $cmd->execute();

        if ($cmd->rowCount() > 0) {
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);

            $this->id = $dados["id"];
            $this->cliente_id = $dados["cliente_id"];
            $this->descricao_problema = $dados["descricao_problema"];
            $this->data_preferida = $dados["data_preferida"];
            $this->status = $dados["status"];
            $this->data_cad = $dados["data_cad"];
            $this->data_atualizacao = $dados["data_atualizacao"];
            $this->data_resposta = $dados["data_resposta"];
            $this->resposta_admin = $dados["resposta_admin"];
            $this->endereco = $dados["endereco"];

            return true;
        }
        return false;
    }

    public function responder(string $resposta, int $status): bool {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes 
                SET resposta_admin = :resposta,
                    status = :status,
                    data_resposta = NOW(),
                    data_atualizacao = NOW()
                WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":resposta", $resposta);
        $cmd->bindValue(":status", $status, PDO::PARAM_INT);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }

    public function atualizarStatus(int $status): bool {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes 
                SET status = :status,
                    data_atualizacao = NOW()
                WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":status", $status, PDO::PARAM_INT);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }
}