<?php

class TurmaCatequeseInscricao {
    private $db;
    public $id;
    public $inscricaoCatequeseId;
    public $turmaCatequeseId;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    function __construct($db) {
        $this->db = $db;
    }

    function loadData($id, $inscricaoCatequeseId, $turmaCatequeseId,
                      $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
		$this->inscricaoCatequeseId = $inscricaoCatequeseId;
        $this->turmaCatequeseId = $turmaCatequeseId;
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
    } 

    function getTurmaCatequeseInscricoes($idTurma) {
        $sql = "SELECT * FROM TurmaCatequeseInscricao WHERE turmaCatequeseId=:idTurma WHERE status = 1";
        $query = $this->db->prepare($sql);
        $query->bindParam("idTurma", $idTurma);
        $query->execute();
       // $query = $this->db->query($sql);
        $inscricoes = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($inscricoes as $inscricao) {
            // Busca de dados relacionados
            //TURMA 
            $sqlx = "SELECT * FROM TurmaCatequese WHERE id=:id";
            $queryx = $this->db->prepare($sqlx);
            $queryx->bindParam("id", $inscricao->turmaCatequeseId);
            $queryx->execute();
            $inscricao->turmaCatequese =  $queryx->fetchObject();
            //Inscricao 
            $sqlx = "SELECT * FROM InscricaoCatequese WHERE id=:id";
            $queryx = $this->db->prepare($sqlx);
            $queryx->bindParam("id", $inscricao->inscricaoCatequeseId);
            $queryx->execute();
            $inscricao->inscricaoCatequese =  $queryx->fetchObject();
            // Inscricao pessoa
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id", $inscricao->inscricaoCatequese->pessoaId);
            $queryp->execute();
            $inscricao->inscricaoCatequese->pessoa =  $queryp->fetchObject();
        }
        echo json_encode($inscricoes);
    }
    

    function getTurmaCatequeseInscricao($id) {
        $sql = "SELECT * FROM TurmaCatequeseInscricao WHERE id=:id AND status = 1";
        $query = $this->db->prepare($sql);
        $query->bindParam("id", $id);
        $query->execute();
        $inscricao = $query->fetchObject();
        
        // Busca de dados relacionados
        //TURMA 
        $sqlx = "SELECT * FROM TurmaCatequese WHERE id=:id";
        $queryx = $this->db->prepare($sqlx);
        $queryx->bindParam("id", $inscricao->turmaCatequeseId);
        $queryx->execute();
        $inscricao->turmaCatequese =  $queryx->fetchObject();
        //Inscricao 
        $sqlx = "SELECT * FROM InscricaoCatequese WHERE id=:id";
        $queryx = $this->db->prepare($sqlx);
        $queryx->bindParam("id", $inscricao->inscricaoCatequeseId);
        $queryx->execute();
        $inscricao->inscricaoCatequese =  $queryx->fetchObject();
        // Inscricao pessoa
        $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
        $queryp = $this->db->prepare($sqlp);
        $queryp->bindParam("id", $inscricao->inscricaoCatequese->pessoaId);
        $queryp->execute();
        $inscricao->inscricaoCatequese->pessoa =  $queryp->fetchObject();
        
        echo json_encode($inscricao);
    }


    function addTurmaCatequeseInscricao() {
        $sql = "INSERT INTO TurmaCatequeseInscricao (`inscricaoCatequeseId`, `turmaCatequeseId`,`status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                VALUES (:inscricaoCatequeseId, :turmaCatequeseId, :status, NOW(), :usuarioUltimaAlteracaoId)";
        
        $query = $this->db->prepare($sql);
        $query->bindParam(":inscricaoCatequeseId",$this->inscricaoCatequeseId);
        $query->bindParam(":turmaCatequeseId",$this->turmaCatequeseId);
        $query->bindParam(":status",$this->status);
        $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }
    
    function saveTurmaCatequeseInscricao()
    {
        $sql = "UPDATE TurmaCatequeseInscricao SET inscricaoCatequeseId=:inscricaoCatequeseId, turmaCatequeseId=:turmaCatequeseId, status=:status, 
                                                    dataUltimaAlteracao=NOW(), usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId
                WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->bindParam(":inscricaoCatequeseId",$this->inscricaoCatequeseId);
      $query->bindParam(":turmaCatequeseId",$this->turmaCatequeseId);
      $query->bindParam(":status",$this->status);
      $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
      $query->execute();
      echo json_encode($this);
    }
    
    function deleteTurmaCatequeseInscricao()
    {
      //$sql = "DELETE FROM TurmaCatequeseInscricao WHERE id=:id";
      $sql = "UPDATE TurmaCatequeseInscricao SET status = 0 WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Turma apagada'}");
    }
}
?>