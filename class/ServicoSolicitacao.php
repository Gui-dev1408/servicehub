<? 
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
  
        public function setServico_Id(int $servico_id)
         {
        $this->servico_id = $servico_id;
        }

         public function getSolicitacao_Id()
        {
        return $this->solicitacao_id;
         }
  
        public function setSolicitacao_Id(int $solicitacao_id)
         {
        $this->solicitacao_id = $solicitacao_id;
        }

         public function getData_Assoc()
        {
        return $this->data_assoc;
         }
  
        public function setData_Assoc(int $data_assoc)
         {
        $this->data_assoc = $data_assoc;
        }


        //metodo listarServicosDaSolicitacao
        public static function listarServicosDaSolicitacao(int $solicitacao_id): array{
         $sql = "select se.*, ss.data_assoc from servico_solicitacao ss inner join servicos se on se.id = ss.servico_id where ss.solicitacao_id = :solicitacao_id";
         $cmd = obterPdo()->prepare($sql);
         $cmd->bindValue(":solicitacao_id", $solicitacao_id, PDO::PARAM_INT);
         $cmd->execute();
         return $cmd->fetchAll(PDO::FETCH_ASSOC);
        }
    

         //metodo associar
            public function associar(int $servico_id, int $solicitacao_id): bool
    {
        //$sql = "INSERT servico_solicitacao VALUES (1, 4, default)"
        $sql = "INSERT servico_solicitacao VALUES (:servico_id, :solicitacao_id default)";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":servico_id",$servico_id ,":solicitacao_id", $solicitacao_id);
        return $cmd->execute();
    }
    
}

?>