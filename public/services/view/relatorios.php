<?php   
    //require 'tcpdf/tcpdf.php';

    // catequizandos-etapas
	$app->get('/relatorios/turmas-comunidade', function($request, $response, $args) {
        $database = db::getInstance();
        $semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
        $sql = "SELECT T.* FROM TurmaCatequese T INNER JOIN Comunidade C ON C.id = T.comunidadeId WHERE T.status=1 ORDER BY C.nome, T.etapaCatequeseId";
        $query = $database->query($sql);
        $turmas = $query->fetchAll(PDO::FETCH_OBJ);
        // $query = $this->db->query($sql);
        // $turmas = $query->fetchObject();
        foreach ($turmas as $turma) {
            $turma->dataInicio = converterDataFromISO($turma->dataInicio);
            $turma->dataTermino = converterDataFromISO($turma->dataTermino);
            // Busca de dados relacionados
            //CATEQUISTA 
            $sqlx = "SELECT * FROM Catequista";
            $queryx = $database->prepare($sqlx);
            $queryx->bindParam("id", $turma->catequistaId);
            $queryx->execute();
            $turma->catequista =  $queryx->fetchObject();
            // catequista pessoa
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $database->prepare($sqlp);
            $queryp->bindParam("id", $turma->catequista->pessoaId);
            $queryp->execute();
            $turma->catequista->pessoa =  $queryp->fetchObject();
            // COMUNIDADE
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $database->prepare($sqlc);
            $queryc->bindParam("id",$turma->comunidadeId);
            $queryc->execute();
            $turma->comunidade =  $queryc->fetchObject();
            // ETAPA
            $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
            $querye = $database->prepare($sqle);
            $querye->bindParam("id",$turma->etapaCatequeseId);
            $querye->execute();
            $turma->etapaCatequese =  $querye->fetchObject();
            // TURNO
            $sqlt = "SELECT * FROM Turno WHERE id=:id";
            $queryt = $database->prepare($sqlt);
            $queryt->bindParam("id",$turma->turnoId);
            $queryt->execute();
            $turma->turno =  $queryt->fetchObject();
            // ANO LETIVO
            $sqlt = "SELECT * FROM AnoLetivoCatequese WHERE id=:id";
            $queryt = $database->prepare($sqlt);
            $queryt->bindParam("id",$turma->anoLetivoId);
            $queryt->execute();
            $turma->anoLetivo =  $queryt->fetchObject();

            $turma->diaSemana = $semana[$turma->diaSemana];
        }
        echo json_encode($turmas);
	})->add($middleAuthorization);

?>