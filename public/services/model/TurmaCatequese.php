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



    function addTurmaCatequese() {
        $sql = "INSERT INTO TurmaCatequese (`etapaCatequeseId`, `comunidadeId`, `catequistaId`, `observacoes`,
                                            `turnoId`, `diaSemana`, `horario`, `dataInicio`, `dataTermino`, 
                                            `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`) 
                VALUES (:etapaCatequeseId, :comunidadeId, :catequistaId, :observacoes,
                        :turnoId, :diaSemana, :horario, :dataInicio, :dataTermino, 
                        :status, NOW(), :usuarioUltimaAlteracaoId)";
        
        $query = $this->db->prepare($sql);
        $query->bindParam(":etapaCatequeseId",$this->etapaCatequeseId);
        $query->bindParam(":comunidadeId",$this->comunidadeId);
        $query->bindParam(":catequistaId",$this->catequistaId);
        $query->bindParam(":observacoes",$this->observacoes);
        $query->bindParam(":turnoId",$this->turnoId);
        $query->bindParam(":diaSemana",$this->diaSemana);
        $query->bindParam(":horario",$this->horario);
        $query->bindParam(":dataInicio",$this->dataInicio);
        $query->bindParam(":dataTermino",$this->dataTermino);
        $query->bindParam(":status",$this->status);
        $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }
    
    function saveTurmaCatequese()
    {
        $sql = "UPDATE TurmaCatequese SET etapaCatequeseId=:etapaCatequeseId, comunidadeId=:comunidadeId, catequistaId=:catequistaId, observacoes=:observacoes,
                                          turnoId=:turnoId, diaSemana=:diaSemana, horario=:horario, dataInicio=:dataInicio, dataTermino=:dataTermino, 
                                          status=:status, dataUltimaAlteracao=NOW(), usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId 
                WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->bindParam(":etapaCatequeseId",$this->etapaCatequeseId);
      $query->bindParam(":comunidadeId",$this->comunidadeId);
      $query->bindParam(":catequistaId",$this->catequistaId);
      $query->bindParam(":observacoes",$this->observacoes);
      $query->bindParam(":turnoId",$this->turnoId);
      $query->bindParam(":diaSemana",$this->diaSemana);
      $query->bindParam(":horario",$this->horario);
      $query->bindParam(":dataInicio",$this->dataInicio);
      $query->bindParam(":dataTermino",$this->dataTermino);
      $query->bindParam(":status",$this->status);
      $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
      $query->execute();
      echo json_encode($this);
    }
    
    function deleteTurmaCatequese()
    {
      $sql = "DELETE FROM TurmaCatequese WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Turma apagada'}");
    }
}
?>