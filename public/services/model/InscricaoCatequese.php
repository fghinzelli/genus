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
    public $comunidadeId;
    public $dataInscricao;
    public $status;
    public $dataUltimaAlteracao;
    public $usuarioUltimaAlteracaoId;
    public $anoLetivoId;
    public $livroPago;
    public $inscricaoPaga;
    public $inscricaoDataPagamento;
    function __construct($db) {
        $this->db = $db;
    }


    function loadData($id, $pessoaId, $etapaCatequeseId, $escolaId, $etapaEscolaId,
                      $observacoes, $situacaoInscricaoId,
                      $comunidadeId, $dataInscricao,
                      $status, $dataUltimaAlteracao, $usuarioUltimaAlteracaoId, $anoLetivoId,
                      $livroPago, $inscricaoPaga, $inscricaoDataPagamento) {
        $this->id = $id;
        $this->pessoaId = $pessoaId;
        $this->etapaCatequeseId = $etapaCatequeseId;
        $this->escolaId = $escolaId;
        $this->etapaEscolaId = $etapaEscolaId;
        $this->observacoes = $observacoes;
        $this->situacaoInscricaoId = $situacaoInscricaoId;
        $this->comunidadeId = $comunidadeId;
        $this->dataInscricao = converterDataToISO($dataInscricao);
        $this->status = $status;
        $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        $this->usuarioUltimaAlteracaoId = $usuarioUltimaAlteracaoId;
        $this->anoLetivoId = $anoLetivoId;
        $this->livroPago = (int)$livroPago;
        $this->inscricaoPaga = (int)$inscricaoPaga;
        $this->inscricaoDataPagamento = converterDataToISO($inscricaoDataPagamento);
    } 

    function getInscricoesCatequese() {
        $sql = "SELECT I.* 
                FROM InscricaoCatequese I 
                INNER JOIN Pessoa P ON I.pessoaId = P.id
                WHERE I.status = 1
                ORDER BY P.nome;";
        $query = $this->db->query($sql);
        $inscricoes = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($inscricoes as $inscricao) {
            // Busca de dados relacionados
            // PESSOA
            $inscricao->dataInscricao = converterDataFromISO($inscricao->dataInscricao);
            $inscricao->inscricaoDataPagamento = converterDataFromISO($inscricao->inscricaoDataPagamento);
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id",$inscricao->pessoaId);
            $queryp->execute();
            $inscricao->pessoa =  $queryp->fetchObject();
            // COMUNIDADE
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $this->db->prepare($sqlc);
            $queryc->bindParam("id",$inscricao->comunidadeId);
            $queryc->execute();
            $inscricao->comunidade =  $queryc->fetchObject();
            // ETAPA CATEQUESE
            $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
            $querye = $this->db->prepare($sqle);
            $querye->bindParam("id",$inscricao->etapaCatequeseId);
            $querye->execute();
            $inscricao->etapaCatequese =  $querye->fetchObject();
            // ANO LETIVO
            $sqlt = "SELECT * FROM AnoLetivoCatequese WHERE id=:id";
            $queryt = $this->db->prepare($sqlt);
            $queryt->bindParam("id",$inscricao->anoLetivoId);
            $queryt->execute();
            $inscricao->anoLetivo =  $queryt->fetchObject();
        }
        echo json_encode($inscricoes);
    }
    

    function getInscricaoCatequese($id)
    {
      $sql = "SELECT I.* FROM InscricaoCatequese I INNER JOIN Pessoa P ON I.pessoaId = P.id WHERE I.id=:id and I.status=1";
      $query = $this->db->prepare($sql);
      $query->bindParam("id", $id);
      $query->execute();
      $inscricao = $query->fetchObject();

      $inscricao->dataInscricao = converterDataFromISO($inscricao->dataInscricao);
      $inscricao->inscricaoDataPagamento = converterDataFromISO($inscricao->inscricaoDataPagamento);
      // PESSOA
      $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
      $queryp = $this->db->prepare($sqlp);
      $queryp->bindParam("id",$inscricao->pessoaId);
      $queryp->execute();
      $inscricao->pessoa =  $queryp->fetchObject();

      // COMUNIDADE
      $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
      $queryc = $this->db->prepare($sqlc);
      $queryc->bindParam("id",$inscricao->comunidadeId);
      $queryc->execute();
      $inscricao->comunidade =  $queryc->fetchObject();
      
      // ETAPA CATEQUESE
      $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
      $querye = $this->db->prepare($sqle);
      $querye->bindParam("id",$inscricao->etapaCatequeseId);
      $querye->execute();
      $inscricao->etapaCatequese =  $querye->fetchObject();

      // ANO LETIVO
      $sqlt = "SELECT * FROM AnoLetivoCatequese WHERE id=:id";
      $queryt = $this->db->prepare($sqlt);
      $queryt->bindParam("id",$inscricao->anoLetivoId);
      $queryt->execute();
      $inscricao->anoLetivo =  $queryt->fetchObject();

      // RESPONSAVEIS
      $sqlr = "SELECT * FROM ResponsavelInscricao WHERE inscricaoCatequeseId=:idInscricao";
      $queryr = $this->db->prepare($sqlr);
      $queryr->bindParam("idInscricao",$inscricao->id);
      $queryr->execute();
      $responsaveis = $queryr->fetchAll(PDO::FETCH_OBJ);
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
      $inscricao->responsaveis = $responsaveis;

      echo json_encode($inscricao);
    }

    function getInscricoesCatequeseByEtapa($idEtapaCatequese, $idAnoLetivo) {
        $sql = "SELECT I.* FROM InscricaoCatequese I INNER JOIN Pessoa P ON I.pessoaId = P.id 
                WHERE I.etapaCatequeseId=:idEtapaCatequese AND I.anoLetivoId=:idAnoLetivo AND I.status = 1
                AND I.id NOT IN (SELECT id FROM view_inscricoesCatequese_incluidas_em_turmas
                                 WHERE anoLetivoId=:idAnoLetivo)
                ORDER BY P.nome;";
        
        $query = $this->db->prepare($sql);
        $query->bindParam("idEtapaCatequese", $idEtapaCatequese);
        $query->bindParam("idAnoLetivo", $idAnoLetivo);
        $query->execute();
        $inscricoes = $query->fetchAll(PDO::FETCH_OBJ);
        //$query = $this->db->query($sql);
        //$inscricoes = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($inscricoes as $inscricao) {
            // Busca de dados relacionados
            $inscricao->dataInscricao = converterDataFromISO($inscricao->dataInscricao);
            $inscricao->inscricaoDataPagamento = converterDataFromISO($inscricao->inscricaoDataPagamento);
            // PESSOA
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $this->db->prepare($sqlp);
            $queryp->bindParam("id",$inscricao->pessoaId);
            $queryp->execute();
            $inscricao->pessoa =  $queryp->fetchObject();
            // COMUNIDADE
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $this->db->prepare($sqlc);
            $queryc->bindParam("id",$inscricao->comunidadeId);
            $queryc->execute();
            $inscricao->comunidade =  $queryc->fetchObject();
            // ETAPA CATEQUESE
            $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
            $querye = $this->db->prepare($sqle);
            $querye->bindParam("id",$inscricao->etapaCatequeseId);
            $querye->execute();
            $inscricao->etapaCatequese =  $querye->fetchObject();
            // ANO LETIVO
            $sqlt = "SELECT * FROM AnoLetivoCatequese WHERE id=:id";
            $queryt = $this->db->prepare($sqlt);
            $queryt->bindParam("id",$inscricao->anoLetivoId);
            $queryt->execute();
            $inscricao->anoLetivo =  $queryt->fetchObject();
        }
        echo json_encode($inscricoes);
    }

    function addInscricaoCatequese() {
        $sql = "INSERT INTO InscricaoCatequese (`pessoaId`, `etapaCatequeseId`, `escolaId`, `etapaEscolaId`, 
                                                `observacoes`, `situacaoInscricaoId`,
                                                `comunidadeId`, `dataInscricao`,
                                                `status`, `dataUltimaAlteracao`, `usuarioUltimaAlteracaoId`, `anoLetivoId`,
                                                `livroPago`, `inscricaoPaga`, `inscricaoDataPagamento`) 
                VALUES (:pessoaId, :etapaCatequeseId, :escolaId, :etapaEscolaId,
                        :observacoes, :situacaoInscricaoId, 
                        :comunidadeId, :dataInscricao,
                        :status, NOW(), :usuarioUltimaAlteracaoId, :anoLetivoId,
                        :livroPago, :inscricaoPaga, :inscricaoDataPagamento)";
        
        $query = $this->db->prepare($sql);
        $query->bindParam(":pessoaId",$this->pessoaId);
        $query->bindParam(":etapaCatequeseId",$this->etapaCatequeseId);
        $query->bindParam(":escolaId",$this->escolaId);
        $query->bindParam(":etapaEscolaId",$this->etapaEscolaId);
        $query->bindParam(":observacoes",$this->observacoes);
        $query->bindParam(":situacaoInscricaoId",$this->situacaoInscricaoId);
        $query->bindParam(":comunidadeId",$this->comunidadeId);
        $query->bindParam(":dataInscricao",$this->dataInscricao);
        $query->bindParam(":status",$this->status);
        $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
        $query->bindParam(":anoLetivoId", $this->anoLetivoId);
        $query->bindParam(":livroPago", $this->livroPago);
        $query->bindParam(":inscricaoPaga", $this->inscricaoPaga);
        $query->bindParam(":inscricaoDataPagamento", $this->inscricaoDataPagamento);
        $query->execute();
        $this->id = $this->db->lastInsertId();
        echo json_encode($this);
    }

    function saveInscricaoCatequese()
    {
        $sql = "UPDATE InscricaoCatequese SET pessoaId=:pessoaId, etapaCatequeseId=:etapaCatequeseId, escolaId=:escolaId, etapaEscolaId=:etapaEscolaId, 
                                              observacoes=:observacoes, situacaoInscricaoId=:situacaoInscricaoId, 
                                              comunidadeId=:comunidadeId, dataInscricao=:dataInscricao,
                                              status=:status, dataUltimaAlteracao=NOW(), usuarioUltimaAlteracaoId=:usuarioUltimaAlteracaoId, anoLetivoId=:anoLetivoId,
                                              livroPago=:livroPago, inscricaoPaga=:inscricaoPaga, inscricaoDataPagamento=:inscricaoDataPagamento
                WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->bindParam(":pessoaId",$this->pessoaId);
      $query->bindParam(":etapaCatequeseId",$this->etapaCatequeseId);
      $query->bindParam(":escolaId",$this->escolaId);
      $query->bindParam(":etapaEscolaId",$this->etapaEscolaId);
      $query->bindParam(":observacoes", $this->observacoes);
      $query->bindParam(":situacaoInscricaoId",$this->situacaoInscricaoId);
      $query->bindParam(":comunidadeId",$this->comunidadeId);
      $query->bindParam(":dataInscricao",$this->dataInscricao);
      $query->bindParam(":status",$this->status);
      $query->bindParam(":usuarioUltimaAlteracaoId", $this->usuarioUltimaAlteracaoId);
      $query->bindParam(":anoLetivoId", $this->anoLetivoId);
      $query->bindParam(":livroPago", $this->livroPago);
      $query->bindParam(":inscricaoPaga", $this->inscricaoPaga);
      $query->bindParam(":inscricaoDataPagamento", $this->inscricaoDataPagamento);
      $query->execute();
      echo json_encode($this);
    }
    
    function deleteInscricaoCatequese()
    {
      //$sql = "DELETE FROM InscricaoCatequese WHERE id=:id";
      $sql = "UPDATE InscricaoCatequese SET status=0 WHERE id=:id";
      $query = $this->db->prepare($sql);
      $query->bindParam(":id",$this->id);
      $query->execute();
      echo json_encode("{'message': 'Inscricao apagada'}");
    }
}
?>