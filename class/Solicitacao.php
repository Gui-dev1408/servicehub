<?php
include_once "config/conexao.php";

class Solicitacao
{
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

    public function __construct()
    {
        $this->pdo = obterPdo();
    }

    // GETTERS / SETTERS
    public function getId(){ return $this->id; }
    public function setId(int $id){ $this->id = $id; }

    public function getClienteId(){ return $this->cliente_id; }
    public function setClienteId(int $cliente_id){ $this->cliente_id = $cliente_id; }

    public function getDescricaoProblema(){ return $this->descricao_problema; }
    public function setDescricaoProblema(string $descricao){ $this->descricao_problema = $descricao; }

    public function getDataPreferida(){ return $this->data_preferida; }
    public function setDataPreferida(string $data){ $this->data_preferida = $data; }

    public function getStatus(){ return $this->status; }
    public function setStatus(string $status){ $this->status = $status; }

    public function getDataCad(){ return $this->data_cad; }
    public function setDataCad(string $data){ $this->data_cad = $data; }

    public function getDataAtualizacao(){ return $this->data_atualizacao; }
    public function setDataAtualizacao(string $data){ $this->data_atualizacao = $data; }

    public function getDataResposta(){ return $this->data_resposta; }
    public function setDataResposta(string $data){ $this->data_resposta = $data; }

    public function getRespostaAdmin(){ return $this->resposta_admin; }
    public function setRespostaAdmin(string $resposta){ $this->resposta_admin = $resposta; }

    public function getEndereco(){ return $this->endereco; }
    public function setEndereco(string $endereco){ $this->endereco = $endereco; }

    // INSERT
    public function inserir(): bool
    {
        $sql = "INSERT INTO solicitacoes 
        (cliente_id, descricao_problema, data_preferida, `status`, data_cad, data_atualizacao, data_resposta, resposta_admin, endereco)
        VALUES 
        (:cliente_id, :descricao_problema, :data_preferida, :status, :data_cad, :data_atualizacao, :data_resposta, :resposta_admin, :endereco)";

        $cmd = $this->pdo->prepare($sql);

        $cmd->bindValue(":cliente_id", $this->cliente_id, PDO::PARAM_INT);
        $cmd->bindValue(":descricao_problema", $this->descricao_problema);
        $cmd->bindValue(":data_preferida", $this->data_preferida);
        $cmd->bindValue(":status", $this->status);
        $cmd->bindValue(":data_cad", $this->data_cad);
        $cmd->bindValue(":data_atualizacao", $this->data_atualizacao);
        $cmd->bindValue(":data_resposta", $this->data_resposta);
        $cmd->bindValue(":resposta_admin", $this->resposta_admin);
        $cmd->bindValue(":endereco", $this->endereco);

        if ($cmd->execute()) {
            $this->id = $this->pdo->lastInsertId();
            return true;
        }

        return false;
    }

    // LISTAR
    public static function listar(): array
    {
        $cmd = obterPdo()->query("SELECT * FROM solicitacoes ORDER BY id DESC");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    // LISTAR POR CLIENTE
    public static function listarPorCliente(int $cliente_id): array
    {
        $sql = "SELECT * FROM solicitacoes WHERE cliente_id = :cliente_id ORDER BY id DESC";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":cliente_id", $cliente_id, PDO::PARAM_INT);
        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    // BUSCAR POR ID
    public function buscarPorId(int $id): bool
    {
        $sql = "SELECT * FROM solicitacoes WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);
        $cmd->execute();

        if ($cmd->rowCount() > 0) {
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);

            $this->id = $dados['id'];
            $this->cliente_id = $dados['cliente_id'];
            $this->descricao_problema = $dados['descricao_problema'];
            $this->data_preferida = $dados['data_preferida'];
            $this->status = $dados['status']; 
            $this->data_cad = $dados['data_cad'];
            $this->data_atualizacao = $dados['data_atualizacao'];
            $this->data_resposta = $dados['data_resposta'];
            $this->resposta_admin = $dados['resposta_admin'];
            $this->endereco = $dados['endereco'];

            return true;
        }

        return false;
    }

    // RESPONDER SOLICITAÇÃO
    public function responderSolicitacao(string $status, string $resposta_admin): bool
    {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes 
                SET `status` = :status, 
                    resposta_admin = :resposta_admin, 
                    data_resposta = NOW() 
                WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":status", $status);
        $cmd->bindValue(":resposta_admin", $resposta_admin);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }

    // ATUALIZAR STATUS
    public function atualizarStatus(string $status): bool
    {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes 
                SET `status` = :status, 
                    data_atualizacao = NOW() 
                WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":status", $status);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }
}
?>