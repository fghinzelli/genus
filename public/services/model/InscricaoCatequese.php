<?php


class InscricaoCatequese {
    private $db;
    public $id;
    public $pessoaId;
    public $etapaCatequeseId;
    public $escolaId;
    public $etapaEscolaId;
    public $observacoes;
    public $situacaoInscricaoId;
    public $turnoId;
    public $situacaoDizimoId;
    public $comunidadeId;
    public $dataInscricao;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    function __construct($db) {
        $this->db = $db;
    }

    function loadData($id, $pessoaId, $etapaCatequeseId, $escolaId, $etapaEscolaId,
                      $observacoes, $situacaoInscricaoId, $turnoId, $situacaoDizimoId,
                      $comunidadeId, $dataInscricao,
                      $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
        $this->pessoaId = $pessoaId;
        $this->etapaCatequeseId = $etapaCatequeseId;
        $this->etapaEscolaId = $etapaEscolaId;
        $this->observacoes = $observacoes;
        $this->situacaoInscricaoId = $situacaoInscricaoId;
        $this->turnoId = $turnoId;
        $this->situacaoDizimoId = $situacaoDizimoId;
        $this->comunidadeId = $comunidadeId;
        $this->dataInscricao = $dataInscricao;
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
    } 

    /////////// ALTERADO ATÉ AQUI !!!!!!!!!!!

    function getInscricoesCatequese() {
        $sql = "SELECT C.* FROM Catequista C INNER JOIN Pessoa P ON C.pessoaId = P.id ORDER BY P.nome;";
        $query = $this->db->query($sql);
        $catequistas = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($catequistas as $catequista) {
            // Busca de dados relacionados
            // PESSOA
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id",$catequista->pessoaId);
            $queryp->execute();
            $catequista->pessoa =  $queryp->fetchObject();
            // COMUNIDADE
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $this->db->prepare($sqlc);
            $queryc->bindParam("id",$catequista->comunidadeId);
            $queryc->execute();
            $catequista->comunidade =  $queryc->fetchObject();
        }
        echo json_encode($catequistas);
    }
    
    function getCatequista($id)
    {
      $sql = "SELECT * FROM Catequista WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $catequista = $query->fetchObject();

      // PESSOA
      $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
      $queryp = $this->db->prepare($sqlp);
      $queryp->bindParam("id",$catequista->pessoaId);
      $queryp->execute();
      $catequista->pessoa =  $queryp->fetchObject();

      // COMUNIDADE
      $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
      $queryc = $this->db->prepare($sqlc);
      $queryc->bindParam("id",$catequista->comunidadeId);
      $queryc->execute();
      $catequista->comunidade =  $queryc->fetchObject();
      
      echo json_encode($catequista);
    }

    function addCatequista() {
        $sql = "INSERT INTO Catequista (`pessoaId`, `comunidadeId`, `dataInicio`, `observacoes`, 
                                    `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                VALUES (:pessoaId, :comunidadeId, :dataInicio, :observacoes, :status, NOW(), :usuarioUltimaAlteracaoId)";
        
        $query = $this->db->prepare($sql);
        $query->bindParam(":pessoaId",$this->pessoaId);
        $query->bindParam(":comunidadeId",$this->comunidadeId);
        $query->bindParam(":dataInicio",$this->dataInicio);
        $query->bindParam(":observacoes",$this->observacoes);
        $query->bindParam(":status",$this->status);
        $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }
    
    function saveCatequista()
    {
        $sql = "UPDATE Catequista SET pessoaId=:pessoaId, comunidadeId=:comunidadeId, dataInicio=:dataInicio, observacoes=:observacoes, 
                                  status=:status, dataUltimaAlteracao=NOW(), usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId 
                WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->bindParam(":pessoaId",$this->pessoaId);
      $query->bindParam(":comunidadeId",$this->comunidadeId);
      $query->bindParam(":dataInicio",$this->dataInicio);
      $query->bindParam(":observacoes", $this->observacoes);
      $query->bindParam(":status",$this->status);
      $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
      $query->execute();
      echo json_encode($this);
    }
    
    function deleteCatequista()
    {
      $sql = "DELETE FROM Catequista WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Catequista apagado'}");
    }
}
?>