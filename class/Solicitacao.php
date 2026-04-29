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

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getCliente_Id()
    {
        return $this->cliente_id;
    }

    public function setCliente_Id(int $cliente_id)
    {
        $this->cliente_id = $cliente_id;
    }

    public function getDescricao_Problema()
    {
        return $this->descricao_problema;
    }

    public function setDescricao_Problema(string $descricao_problema)
    {
        $this->descricao_problema = $descricao_problema;
    }   

    public function getData_Preferida()
    {
        return $this->data_preferida;
    }

    public function setDataPreferida(string $data_preferida)
    {
        $this->data_preferida = $data_preferida;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function getData_Cad()
    {
        return $this->data_cad;
    }

    public function setData_Cad(string $data_cad)
    {
        $this->data_cad = $data_cad;
    }

    public function getData_Atualizacao()
    {
        return $this->data_atualizacao;
    }

    public function setData_Atualizacao(string $data_atualizacao)
    {
        $this->data_atualizacao = $data_atualizacao;
    }

    public function getData_Resposta()
    {
        return $this->data_resposta;
    }

    public function setData_Resposta(string $data_resposta)
    {
        $this->data_resposta = $data_resposta;
    }

    public function getResposta_Admin()
    {
        return $this->resposta_admin;
    }

    public function setResposta_Admin(string $resposta_admin)
    {
        $this->resposta_admin = $resposta_admin;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco)
    {
        $this->endereco = $endereco;
    }

    
    public function inserir(): bool
    {
        $sql = "INSERT INTO solicitacoes 
        (cliente_id, descricao_problema, data_preferida, status, data_cad, data_atualizacao, data_resposta, resposta_admin, endereco) 
        VALUES 
        (:cliente_id, :descricao_problema, :data_preferida, :status, :data_cad, :data_atualizacao, :data_resposta, :resposta_admin, :endereco)";
   

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":cliente_id", $this->cliente_id, PDO::PARAM_INT);
        $cmd->bindValue(":descricao_problema", $this->descricao_problema, PDO::PARAM_STR);
        $cmd->bindValue(":data_preferida", $this->data_preferida, PDO::PARAM_STR);
        $cmd->bindValue(":status", $this->status, PDO::PARAM_STR);
        $cmd->bindValue(":data_cad", $this->data_cad, PDO::PARAM_STR);
        $cmd->bindValue(":data_atualizacao", $this->data_atualizacao, PDO::PARAM_STR);
        $cmd->bindValue(":data_resposta", $this->data_resposta, PDO::PARAM_STR);
        $cmd->bindValue(":resposta_admin", $this->resposta_admin, PDO::PARAM_STR);
        $cmd->bindValue(":endereco", $this->endereco, PDO::PARAM_STR);

        if ($cmd->execute()) {
            $this->id = $this->pdo->lastInsertId();
            return true;
        }
        return false;
    }

    // método listar
    public static function listar(): array
    {
        $cmd = obterPdo()->query("SELECT * FROM solicitacoes ORDER BY id");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    // método listar por cliente
    public static function listarPorCliente(int $cliente_id): array
    {
        $sql = "SELECT * FROM solicitacoes WHERE cliente_id = :cliente_id ORDER BY id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":cliente_id", $cliente_id, PDO::PARAM_INT);
        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    // método buscar por id
    public function buscarPorId(int $id): bool
    {
        $sql = "SELECT * FROM solicitacoes WHERE id=:id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);
        $cmd->execute();

        if ($cmd->rowCount() > 0) {
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            $this->setId($dados['id']);
            $this->setCliente_Id($dados['cliente_id']);
            $this->setDescricao_Problema($dados['descricao_problema']);
            $this->setDataPreferida($dados['data_preferida']);
            $this->setStatus($dados['status']);
            $this->setData_Cad($dados['data_cad']);
            $this->setData_Atualizacao($dados['data_atualizacao']);
            $this->setData_Resposta($dados['data_resposta']);
            $this->setResposta_Admin($dados['resposta_admin']);
            $this->setEndereco($dados['endereco']);
            return true;
        }
        return false;
    }

    // método responder solicitação
    public function responderSolicitacao(int $status, string $resposta_admin): bool
    {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes 
                SET status = :status, resposta_admin = :resposta_admin, data_resposta = NOW() 
                WHERE id = :id";
        // ✅ ALTERADO: removido 'status' com aspas

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":status", $status, PDO::PARAM_STR);
        $cmd->bindValue(":resposta_admin", $resposta_admin, PDO::PARAM_STR);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }

    // método atualizar status
    public function atualizarStatus(int $status): bool
    {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes 
                SET status = :status, data_atualizacao = NOW() 
                WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":status", $status, PDO::PARAM_STR);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }   
}

// ❌ REMOVIDO: não colocar "?>" no final do arquivo PHP