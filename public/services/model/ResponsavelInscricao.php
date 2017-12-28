<?php

class ResponsavelInscricao {
    private $db;
    public $id;
    public $inscricaoCatequeseId;
    public $pessoaResponsavelId;
    public $observacoes;
    public $parentescoId;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    function __construct($db) {
        $this->db = $db;
    }

    function loadData($id, $inscricaoCatequeseId, $pessoaResponsavelId, $observacoes, $parentescoId,
                      $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
		$this->inscricaoCatequeseId = $inscricaoCatequeseId;
        $this->pessoaResponsavelId = $pessoaResponsavelId;
        $this->observacoes = $observacoes;
        $this->parentescoId = $parentescoId;
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
    } 

    function getResponsaveisInscricao($idInscricao) {
        $sql = "SELECT * FROM ResponsavelInscricao WHERE inscricaoCatequeseId=:idInscricao";
        $query = $this->db->prepare($sql);
        $query->bindParam("idInscricao", $idInscricao);
        $query->execute();
       // $query = $this->db->query($sql);
        $responsaveis = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($responsaveis as $responsavel) {
            // Busca de dados relacionados
            // PARENTESCO 
            $sqlx = "SELECT * FROM Parentesco WHERE id=:id";
            $queryx = $this->db->prepare($sqlx);
            $queryx->bindParam("id", $responsavel->parentescoId);
            $queryx->execute();
            $responsavel->parentesco =  $queryx->fetchObject();
            // PESSOA
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id", $responsavel->pessoaResponsavelId);
            $queryp->execute();
            $responsavel->pessoa =  $queryp->fetchObject();
        }
        echo json_encode($responsaveis);
    }

    function addResponsavelInscricao() {
        $sql = "INSERT INTO ResponsavelInscricao (`inscricaoCatequeseId`, `pessoaResponsavelId`, `observacoes`, `parentescoId`,`status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                VALUES (:inscricaoCatequeseId, :pessoaResponsavelId, :observacoes, :parentescoId, :status, NOW(), :usuarioUltimaAlteracaoId)";
        
        $query = $this->db->prepare($sql);
        $query->bindParam(":inscricaoCatequeseId",$this->inscricaoCatequeseId);
        $query->bindParam(":pessoaResponsavelId",$this->pessoaResponsavelId);
        $query->bindParam(":observacoes",$this->observacoes);
        $query->bindParam(":parentescoId",$this->parentescoId);
        $query->bindParam(":status",$this->status);
        $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }
    
    function deleteResponsavelInscricao()
    {
      $sql = "DELETE FROM ResponsavelInscricao WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Responsavel apagado'}");
    }
}
?>