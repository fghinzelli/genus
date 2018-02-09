<?php   
    require 'tcpdf/tcpdf.php';

    // catequizandos-etapas
	$app->get('/relatorios/catequizandos-etapas', function($request, $response, $args) {
		$semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
        $sql = "SELECT * FROM TurmaCatequese WHERE status=1";
        $query = $this->db->prepare($sql);
        $query->execute();
        // $query = $this->db->query($sql);
        // $turmas = $query->fetchObject();
        $turmas = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($turmas as $turma) {
            $turma->dataInicio = converterDataFromISO($turma->dataInicio);
            $turma->dataTermino = converterDataFromISO($turma->dataTermino);
            // Busca de dados relacionados
            //CATEQUISTA 
            $sqlx = "SELECT * FROM Catequista";
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
	})->add($middleAuthorization);

?>