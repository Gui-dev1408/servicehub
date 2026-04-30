<?php 
include_once "config/conexao.php";

class ServicoSolicitacao
{ 
    private $servico_id;
    private $solicitacao_id;
    private $data_assoc;
    private $pdo;

    public function __construct()
    {
        $this->pdo = obterPdo(); 
    }

    public function getServico_Id()
    {
        return $this->servico_id;
    }

    public function setServicoId(int $servico_id)
    {
        $this->servico_id = $servico_id;
    }

    public function getSolicitacaoId()
    {
        return $this->solicitacao_id;
    }

    public function setSolicitacaoId(int $solicitacao_id)
    {
        $this->solicitacao_id = $solicitacao_id;
    }

    public function getDataAssoc()
    {
        return $this->data_assoc;
    }

    public function setDataAssoc(string $data_assoc)
    {
        $this->data_assoc = $data_assoc;
    }

    // metodo listarServicosDaSolicitacao
    public static function listarServicosDaSolicitacao(int $solicitacao_id): array
    {
        $sql = "SELECT se.*, ss.data_assoc 
                FROM servico_solicitacao ss 
                INNER JOIN servicos se 
                ON se.id = ss.servico_id 
                WHERE ss.solicitacao_id = :solicitacao_id";

        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":solicitacao_id", $solicitacao_id, PDO::PARAM_INT);
        $cmd->execute();

        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo associar
    public function associar(int $servico_id, int $solicitacao_id): bool
    {
        $sql = "INSERT INTO servico_solicitacao (servico_id, solicitacao_id, data_assoc) 
                VALUES (:servico_id, :solicitacao_id, NOW())";

        $cmd = $this->pdo->prepare($sql);

      
        $cmd->bindValue(":servico_id", $servico_id, PDO::PARAM_INT);

     
        $cmd->bindValue(":solicitacao_id", $solicitacao_id, PDO::PARAM_INT);

        return $cmd->execute();
    }
}
?>