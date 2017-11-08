<?php


class TurmaCatequese {
    private $db;
    public $id;
    public $etapaCatequeseId;
    public $comunidadeId;
    public $catequistaId;
    public $observacoes;
    public $turnoId;
    public $diaSemana;
    public $horario;
    public $dataInicio;
    public $dataTermino;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    function __construct($db) {
        $this->db = $db;
    }

    function loadData($id, $etapaCatequeseId, $comunidadeId, $catequistaId, $observacoes, 
                      $turnoId, $diaSemana, $horario, $dataInicio, $dataTermino,
                      $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId) {
        $this->id = $id;
		$this->etapaCatequeseId = $etapaCatequeseId;
        $this->comunidadeId = $comunidadeId;
        $this->catequistaId = $catequistaId;
        $this->observacoes = $observacoes;
        $this->turnoId = $turnoId;
        $this->diaSemana = $diaSemana;
        $this->horario = $horario;
        $this->dataInicio = converterDataToISO($dataInicio);
        $this->dataTermino = converterDataToISO($dataTermino);
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
    } 

    function getTurmasCatequese() {
        $sql = "SELECT * FROM TurmaCatequese";
        $query = $this->db->query($sql);
        $turmas = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($turmas as $turma) {
            $turma->dataInicio = converterDataFromISO($turma->dataInicio);
            $turma->dataTermino = converterDataFromISO($turma->dataTermino);
        }
        echo json_encode($turmas);
    }
    

    function getTurmaCatequese($id)
    {
      $sql = "SELECT * FROM TurmaCatequese WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $turma = $query->fetchObject();
      $turma->dataInicio = converterDataFromISO($turma->dataInicio);
      $turma->dataTermino = converterDataFromISO($turma->dataTermino);    
      echo json_encode($turma);
    }

    //////////// CONTINUAR DAQUI


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