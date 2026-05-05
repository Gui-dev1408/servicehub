<?php
//incluir conexão
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

    //contrutor
    public function __construct()
    {
        $this->pdo = obterPdo();
    }
    //Getters e Setters
    //ID
    public function getId()
    {
        return $this->id;
    }
    //Cliente
    public function setClienteId(int $cliente_id)
    {
        return $this->cliente_id = $cliente_id;
    }

    //Descrição do Problema
    public function setDescricaoProblema(string $descricao_problema)
    {
        return $this->descricao_problema = $descricao_problema;
    }

    public function getDescricaoProblema()
    {
        return $this->descricao_problema;
    }
    //Data Preferida
    public function setDataPreferida($data_preferida)
    {
        return $this->data_preferida = $data_preferida;
    }
    public function getDataPreferida()
    {
        return $this->data_preferida;
    }
    // endereco
    public function setEndereco(string $endereco)
    {
        return $this->endereco = $endereco;
    }
    public function getEndereco()
    {
        return $this->endereco;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getRespostaAdmin()
    {
        return $this->resposta_admin;
    }
    public function getDataCadastro()
    {
        return $this->data_cad;
    }
    //Métodos obrigatórios:
    //Inserir
    public function inserir(): bool
    {
        $sql = "INSERT into solicitacoes (cliente_id, descricao_problema, data_preferida, status, endereco) values(:cliente_id, :descricao, :data_preferida, 1, :endereco)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":cliente_id", $this->cliente_id, PDO::PARAM_INT);
        $cmd->bindValue(":descricao_problema", $this->descricao_problema);
        $cmd->bindValue(":data_preferida", $this->data_preferida);
        $cmd->bindValue(":endereco", $this->endereco);
        if ($cmd->execute()) {
            $this->id = $this->pdo->lastInsertId();;
            return true;
        }
        return false;
    }
    //Listar
    public static function listar(): array
    {
        $sql = "SELECT * FROM solicitacoes ORDER BY data_cad DESC";
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
    public function listarServicosPorSolicitacao(int $solicitacao_id): array
    {
        $sql = "SELECT s.nome, s.preco 
            FROM servico_solicitacao ss
            JOIN servicos s ON ss.servico_id = s.id
            WHERE ss.solicitacao_id = :solicitacao_id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":solicitacao_id", $solicitacao_id, PDO::PARAM_INT);
        $cmd->execute();

        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }
    //Listar Por Cliente
    public static function listarPorCliente(int $usuario_id): array
    {
        $sql = "SELECT s.* FROM solicitacoes s 
            JOIN clientes c ON s.cliente_id = c.id 
            WHERE c.usuario_id = :usuario_id";

        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":usuario_id", $usuario_id, PDO::PARAM_INT);

        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar Por Id
    public function buscarPorId(int $id): bool
    {
        $sql = "SELECT * FROM solicitacoes WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);
        $cmd->execute();
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        if ($dados) {
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

    //Responder
    public function responder(string $resposta, int $status): bool
    {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes SET resposta_admin = :resposta, status = :status, data_resposta = NOW(), data_atualizacao = NOW() WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":resposta", $resposta);
        $cmd->bindValue(":status", $status, PDO::PARAM_INT);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }

    //Atualizar Status
    public function atualizarStatus(int $status): bool
    {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes SET status = :status, data_atualizacao = NOW() WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":status", $status, PDO::PARAM_INT);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }
}