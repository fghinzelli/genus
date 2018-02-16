<?php   
    // Catequizandos por Etapa
	$app->get('/relatorios/catequizandos-etapas', function($request, $response, $args) {
        $database = db::getInstance();
        $semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
        $sql = "SELECT TI.* 
                FROM TurmaCatequeseInscricao TI
                    INNER JOIN InscricaoCatequese I ON I.id = TI.inscricaoCatequeseId
                    INNER JOIN Pessoa P ON P.id = I.pessoaId
                    INNER JOIN EtapaCatequese EC ON EC.id = I.etapaCatequeseId
                WHERE TI.status = 1
                ORDER BY EC.id, P.nome";
        $query = $database->query($sql);
        $inscricoes = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($inscricoes as $inscricao) {
            // Busca de dados relacionados
            //TURMA 
            $sqlx = "SELECT * FROM TurmaCatequese WHERE id=:id";
            $queryx = $database->prepare($sqlx);
            $queryx->bindParam("id", $inscricao->turmaCatequeseId);
            $queryx->execute();
            $inscricao->turmaCatequese =  $queryx->fetchObject();
            //Inscricao 
            $sqlx = "SELECT * FROM InscricaoCatequese WHERE id=:id";
            $queryx = $database->prepare($sqlx);
            $queryx->bindParam("id", $inscricao->inscricaoCatequeseId);
            $queryx->execute();
            $inscricao->inscricaoCatequese =  $queryx->fetchObject();
            // Inscricao pessoa
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $database->prepare($sqlp);
            $queryp->bindParam("id", $inscricao->inscricaoCatequese->pessoaId);
            $queryp->execute();
            $inscricao->inscricaoCatequese->pessoa =  $queryp->fetchObject();
            // ETAPA CATEQUESE
            $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
            $querye = $database->prepare($sqle);
            $querye->bindParam("id",$inscricao->inscricaoCatequese->etapaCatequeseId);
            $querye->execute();
            $inscricao->inscricaoCatequese->etapaCatequese =  $querye->fetchObject();
            // comunidade
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $database->prepare($sqlc);
            $queryc->bindParam("id",$inscricao->inscricaoCatequese->comunidadeId);
            $queryc->execute();
            $inscricao->inscricaoCatequese->comunidade =  $queryc->fetchObject();
        }
        echo json_encode($inscricoes);
	})->add($middleAuthorization);

    // Catequizandos por Turma
	$app->get('/relatorios/catequizandos-turmas', function($request, $response, $args) {
        $database = db::getInstance();
        $semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
        $sql = "SELECT TI.* 
                FROM TurmaCatequeseInscricao TI
                    INNER JOIN InscricaoCatequese I ON I.id = TI.inscricaoCatequeseId
                    INNER JOIN Pessoa P ON P.id = I.pessoaId
                    INNER JOIN EtapaCatequese EC ON EC.id = I.etapaCatequeseId
                    INNER JOIN TurmaCatequese TC ON TC.id = TI.turmaCatequeseId
                    INNER JOIN Comunidade C ON C.id = I.comunidadeId
                    INNER JOIN Catequista CT ON CT.id = TC.catequistaId
                    INNER JOIN Pessoa CP ON CP.id = CT.pessoaId
                WHERE TI.status = 1
                ORDER BY C.nome, EC.id, P.nome";
        $query = $database->query($sql);
        $inscricoes = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($inscricoes as $inscricao) {
            // Busca de dados relacionados
            //TURMA 
            $sqlx = "SELECT * FROM TurmaCatequese WHERE id=:id";
            $queryx = $database->prepare($sqlx);
            $queryx->bindParam("id", $inscricao->turmaCatequeseId);
            $queryx->execute();
            $inscricao->turmaCatequese =  $queryx->fetchObject();
            $inscricao->turmaCatequese->diaSemana = $semana[$inscricao->turmaCatequese->diaSemana];
            
            //Inscricao 
            $sqlx = "SELECT * FROM InscricaoCatequese WHERE id=:id";
            $queryx = $database->prepare($sqlx);
            $queryx->bindParam("id", $inscricao->inscricaoCatequeseId);
            $queryx->execute();
            $inscricao->inscricaoCatequese =  $queryx->fetchObject();
            // Inscricao pessoa
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $database->prepare($sqlp);
            $queryp->bindParam("id", $inscricao->inscricaoCatequese->pessoaId);
            $queryp->execute();
            $inscricao->inscricaoCatequese->pessoa =  $queryp->fetchObject();
            // ETAPA CATEQUESE
            $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
            $querye = $database->prepare($sqle);
            $querye->bindParam("id",$inscricao->inscricaoCatequese->etapaCatequeseId);
            $querye->execute();
            $inscricao->inscricaoCatequese->etapaCatequese =  $querye->fetchObject();
            // comunidade
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $database->prepare($sqlc);
            $queryc->bindParam("id",$inscricao->inscricaoCatequese->comunidadeId);
            $queryc->execute();
            $inscricao->inscricaoCatequese->comunidade =  $queryc->fetchObject();
            // Catequista
            $sqlc = "SELECT * FROM Catequista WHERE id=:id";
            $queryc = $database->prepare($sqlc);
            $queryc->bindParam("id",$inscricao->turmaCatequese->catequistaId);
            $queryc->execute();
            $inscricao->turmaCatequese->catequista =  $queryc->fetchObject();

            // Catequista->Pessoa
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $database->prepare($sqlp);
            $queryp->bindParam("id", $inscricao->turmaCatequese->catequista->pessoaId);
            $queryp->execute();
            $inscricao->turmaCatequese->catequista->pessoa =  $queryp->fetchObject();
        }
        echo json_encode($inscricoes);
    })->add($middleAuthorization);
    
    // Catequizandos e Padrinhos (Crisma)
	$app->get('/relatorios/catequizandos-padrinhos', function($request, $response, $args) {
        $database = db::getInstance();
        $semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
        $sql = "SELECT TI.* 
                FROM TurmaCatequeseInscricao TI
                    INNER JOIN InscricaoCatequese I ON I.id = TI.inscricaoCatequeseId
                    INNER JOIN Pessoa P ON P.id = I.pessoaId
                    INNER JOIN EtapaCatequese EC ON EC.id = I.etapaCatequeseId
                    INNER JOIN TurmaCatequese TC ON TC.id = TI.turmaCatequeseId
                    INNER JOIN Comunidade C ON C.id = I.comunidadeId
                    INNER JOIN Catequista CT ON CT.id = TC.catequistaId
                    INNER JOIN Pessoa CP ON CP.id = CT.pessoaId
                WHERE TI.status = 1 AND EC.id = 4 AND I.status = 1
                ORDER BY C.nome, EC.id, P.nome";
        $query = $database->query($sql);
        $inscricoes = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($inscricoes as $inscricao) {
            // Busca de dados relacionados
            //TURMA 
            $sqlx = "SELECT * FROM TurmaCatequese WHERE id=:id";
            $queryx = $database->prepare($sqlx);
            $queryx->bindParam("id", $inscricao->turmaCatequeseId);
            $queryx->execute();
            $inscricao->turmaCatequese =  $queryx->fetchObject();
            $inscricao->turmaCatequese->diaSemana = $semana[$inscricao->turmaCatequese->diaSemana];
            
            //Inscricao 
            $sqlx = "SELECT * FROM InscricaoCatequese WHERE id=:id";
            $queryx = $database->prepare($sqlx);
            $queryx->bindParam("id", $inscricao->inscricaoCatequeseId);
            $queryx->execute();
            $inscricao->inscricaoCatequese =  $queryx->fetchObject();
            // Inscricao pessoa
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $database->prepare($sqlp);
            $queryp->bindParam("id", $inscricao->inscricaoCatequese->pessoaId);
            $queryp->execute();
            $inscricao->inscricaoCatequese->pessoa =  $queryp->fetchObject();
            // ETAPA CATEQUESE
            $sqle = "SELECT * FROM EtapaCatequese WHERE id=:id";
            $querye = $database->prepare($sqle);
            $querye->bindParam("id",$inscricao->inscricaoCatequese->etapaCatequeseId);
            $querye->execute();
            $inscricao->inscricaoCatequese->etapaCatequese =  $querye->fetchObject();
            // comunidade
            $sqlc = "SELECT * FROM Comunidade WHERE id=:id";
            $queryc = $database->prepare($sqlc);
            $queryc->bindParam("id",$inscricao->inscricaoCatequese->comunidadeId);
            $queryc->execute();
            $inscricao->inscricaoCatequese->comunidade =  $queryc->fetchObject();
            // Catequista
            $sqlc = "SELECT * FROM Catequista WHERE id=:id";
            $queryc = $database->prepare($sqlc);
            $queryc->bindParam("id",$inscricao->turmaCatequese->catequistaId);
            $queryc->execute();
            $inscricao->turmaCatequese->catequista =  $queryc->fetchObject();

            // Catequista->Pessoa
            $sqlp = "SELECT * FROM Pessoa WHERE id=:id";
            $queryp = $database->prepare($sqlp);
            $queryp->bindParam("id", $inscricao->turmaCatequese->catequista->pessoaId);
            $queryp->execute();
            $inscricao->turmaCatequese->catequista->pessoa =  $queryp->fetchObject();
        }
        echo json_encode($inscricoes);
    })->add($middleAuthorization);

    // turmas-comunidade
	$app->get('/relatorios/turmas-comunidade', function($request, $response, $args) {
        $database = db::getInstance();
        $semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
        $sql = "SELECT T.* FROM TurmaCatequese T INNER JOIN Comunidade C ON C.id = T.comunidadeId WHERE T.status=1 ORDER BY C.nome, T.etapaCatequeseId";
        $query = $database->query($sql);
        $turmas = $query->fetchAll(PDO::FETCH_OBJ);

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