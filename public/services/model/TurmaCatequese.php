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
    public $anoLetivoId;
    function __construct($db) {
        $this->db = $db;
    }

    function loadData($id, $etapaCatequeseId, $comunidadeId, $catequistaId, $observacoes, 
                      $turnoId, $diaSemana, $horario, $dataInicio, $dataTermino,
                      $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId, $anoLetivoId) {
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
        $this->anoLetivoId = $anoLetivoId;
    } 

    function getTurmasCatequese() {
        $semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
        $sql = "SELECT * FROM TurmaCatequese WHERE status = 1";
        $query = $this->db->query($sql);
        $turmas = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($turmas as $turma) {
            $turma->dataInicio = converterDataFromISO($turma->dataInicio);
            $turma->dataTermino = converterDataFromISO($turma->dataTermino);
            // Busca de dados relacionados
            //CATEQUISTA 
            $sqlx = "SELECT * FROM Catequista WHERE id=:id";
            $queryx = $this->db->prepare($sqlx);
            $queryx->bindParam("id", $turma->catequistaId);
            $queryx->execute();
            $turma->catequista =  $queryx->fetchObject();
            // catequista pessoa
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id", $turma->catequista->pessoaId);
            $queryp->execute();
            $turma->catequista->pessoa =  $queryp->fetchObject();
            // COMUNIDADE
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $this->db->prepare($sqlc);
            $queryc->bindParam("id",$turma->comunidadeId);
            $queryc->execute();
            $turma->comunidade =  $queryc->fetchObject();
            // ETAPA
            $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
            $querye = $this->db->prepare($sqle);
            $querye->bindParam("id",$turma->etapaCatequeseId);
            $querye->execute();
            $turma->etapaCatequese =  $querye->fetchObject();
            // TURNO
            $sqlt = "SELECT * FROM Turno WHERE id=:id";
            $queryt = $this->db->prepare($sqlt);
            $queryt->bindParam("id",$turma->turnoId);
            $queryt->execute();
            $turma->turno =  $queryt->fetchObject();
            // ANO LETIVO
            $sqlt = "SELECT * FROM AnoLetivoCatequese WHERE id=:id";
            $queryt = $this->db->prepare($sqlt);
            $queryt->bindParam("id",$turma->anoLetivoId);
            $queryt->execute();
            $turma->anoLetivo =  $queryt->fetchObject();

            $turma->diaSemana = $semana[$turma->diaSemana];
        }
        echo json_encode($turmas);
    }
    
    function getTurmasCatequeseByComunidade($idComunidade) {
        $semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
        $sql = "SELECT * FROM TurmaCatequese WHERE status=1 AND comunidadeId=:idComunidade";
        $query = $this->db->prepare($sql);
        $query->bindParam("idComunidade", $idComunidade);
        $query->execute();
        // $query = $this->db->query($sql);
        // $turmas = $query->fetchObject();
        $turmas = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($turmas as $turma) {
            $turma->dataInicio = converterDataFromISO($turma->dataInicio);
            $turma->dataTermino = converterDataFromISO($turma->dataTermino);
            // Busca de dados relacionados
            //CATEQUISTA 
            $sqlx = "SELECT * FROM Catequista WHERE id=:id";
            $queryx = $this->db->prepare($sqlx);
            $queryx->bindParam("id", $turma->catequistaId);
            $queryx->execute();
            $turma->catequista =  $queryx->fetchObject();
            // catequista pessoa
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id", $turma->catequista->pessoaId);
            $queryp->execute();
            $turma->catequista->pessoa =  $queryp->fetchObject();
            // COMUNIDADE
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $this->db->prepare($sqlc);
            $queryc->bindParam("id",$turma->comunidadeId);
            $queryc->execute();
            $turma->comunidade =  $queryc->fetchObject();
            // ETAPA
            $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
            $querye = $this->db->prepare($sqle);
            $querye->bindParam("id",$turma->etapaCatequeseId);
            $querye->execute();
            $turma->etapaCatequese =  $querye->fetchObject();
            // TURNO
            $sqlt = "SELECT * FROM Turno WHERE id=:id";
            $queryt = $this->db->prepare($sqlt);
            $queryt->bindParam("id",$turma->turnoId);
            $queryt->execute();
            $turma->turno =  $queryt->fetchObject();
            // ANO LETIVO
            $sqlt = "SELECT * FROM AnoLetivoCatequese WHERE id=:id";
            $queryt = $this->db->prepare($sqlt);
            $queryt->bindParam("id",$turma->anoLetivoId);
            $queryt->execute();
            $turma->anoLetivo =  $queryt->fetchObject();

            $turma->diaSemana = $semana[$turma->diaSemana];
        }
        echo json_encode($turmas);
    }

    function getTurmaCatequese($id) {
        $semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
      $sql = "SELECT * FROM TurmaCatequese WHERE status = 1 AND id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $turma = $query->fetchObject();
      $turma->dataInicio = converterDataFromISO($turma->dataInicio);
      $turma->dataTermino = converterDataFromISO($turma->dataTermino);
      
      //CATEQUISTA 
      $sqlx = "SELECT * FROM Catequista WHERE id=:id";
      $queryx = $this->db->prepare($sqlx);
      $queryx->bindParam("id", $turma->catequistaId);
      $queryx->execute();
      $turma->catequista =  $queryx->fetchObject();
      // catequista pessoa
      $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
      $queryp = $this->db->prepare($sqlp);
      $queryp->bindParam("id", $turma->catequista->pessoaId);
      $queryp->execute();
      $turma->catequista->pessoa =  $queryp->fetchObject();
      
      // COMUNIDADE
      $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
      $queryc = $this->db->prepare($sqlc);
      $queryc->bindParam("id", $turma->comunidadeId);
      $queryc->execute();
      $turma->comunidade =  $queryc->fetchObject();
      // ETAPA
      $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
      $querye = $this->db->prepare($sqle);
      $querye->bindParam("id", $turma->etapaCatequeseId);
      $querye->execute();
      $turma->etapaCatequese =  $querye->fetchObject();
      // TURNO
      $sqlt = "SELECT * FROM Turno WHERE id=:id";
      $queryt = $this->db->prepare($sqlt);
      $queryt->bindParam("id", $turma->turnoId);
      $queryt->execute();
      $turma->turno =  $queryt->fetchObject();
      // ANO LETIVO
      $sqlt = "SELECT * FROM AnoLetivoCatequese WHERE id=:id";
      $queryt = $this->db->prepare($sqlt);
      $queryt->bindParam("id",$turma->anoLetivoId);
      $queryt->execute();
      $turma->anoLetivo =  $queryt->fetchObject();
      // INSCRICOES
      
      $sql = "SELECT I.*, TC.id AS idInscricaoTurma FROM TurmaCatequeseInscricao TC 
              INNER JOIN InscricaoCatequese I ON I.id = TC.inscricaoCatequeseId
              INNER JOIN Pessoa P ON I.pessoaId = P.id
              WHERE TC.turmaCatequeseId=:idTurma AND I.status = 1 AND TC.status = 1
              ORDER BY P.nome;";
      $query = $this->db->prepare($sql);
      $query->bindParam("idTurma", $turma->id);
      $query->execute();
      $inscricoes = $query->fetchAll(PDO::FETCH_OBJ);
      foreach ($inscricoes as $inscricao) {
          // Busca de dados relacionados
          // PESSOA
          $inscricao->dataInscricao = converterDataFromISO($inscricao->dataInscricao);
          $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
          $queryp = $this->db->prepare($sqlp);
          $queryp->bindParam("id",$inscricao->pessoaId);
          $queryp->execute();
          $inscricao->pessoa =  $queryp->fetchObject();
          $inscricao->pessoa->dataNascimento = converterDataFromISO($inscricao->pessoa->dataNascimento);
      }
      $turma->inscricoes = $inscricoes;
      
      
      echo json_encode($turma);
    }



    function addTurmaCatequese() {
        $sql = "INSERT INTO TurmaCatequese (`etapaCatequeseId`, `comunidadeId`, `catequistaId`, `observacoes`,
                                            `turnoId`, `diaSemana`, `horario`, `dataInicio`, `dataTermino`, 
                                            `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`, `anoLetivoId`) 
                VALUES (:etapaCatequeseId, :comunidadeId, :catequistaId, :observacoes,
                        :turnoId, :diaSemana, :horario, :dataInicio, :dataTermino, 
                        :status, NOW(), :usuarioUltimaAlteracaoId, :anoLetivoId)";
        
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
        $query->bindParam(":anoLetivoId", $this->anoLetivoId);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }
    
    function saveTurmaCatequese()
    {
        $sql = "UPDATE TurmaCatequese SET etapaCatequeseId=:etapaCatequeseId, comunidadeId=:comunidadeId, catequistaId=:catequistaId, observacoes=:observacoes,
                                          turnoId=:turnoId, diaSemana=:diaSemana, horario=:horario, dataInicio=:dataInicio, dataTermino=:dataTermino, 
                                          status=:status, dataUltimaAlteracao=NOW(), usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId, anoLetivoId=:anoLetivoId 
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
      $query->bindParam(":anoLetivoId", $this->anoLetivoId);
      $query->execute();
      echo json_encode($this);
    }
    
    function deleteTurmaCatequese()
    {
      //$sql = "DELETE FROM TurmaCatequese WHERE id=:id";
      $sql = "UPDATE TurmaCatequese SET status = 0 WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Turma apagada'}");
    }
}
?>