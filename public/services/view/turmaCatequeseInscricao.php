<?php
    require 'model/TurmaCatequeseInscricao.php';

	// SELECT ALL OF A TURMA
	$app->get('/turmas-catequese-inscricoes/turma/{idTurma}', function($request, $response, $args) {
		$inscricoes = new TurmaCatequeseInscricao(db::getInstance());
		$result = $inscricoes->getTurmaCatequeseInscricoes($args['idTurma']);
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	// SELECT BY id
	$app->get('/turmas-catequese-inscricoes/{id}', function($request, $response, $args) {
		$inscricao = new TurmaCatequeseInscricao(db::getInstance());
		$result = $inscricao->getTurmaCatequeseInscricao($args['id']);
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'No records found.' ))));
		} else {
			return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json;charset=utf-8')
			->write($result);
		}
	})->add($middleAuthorization);

	
	// INSERT
	$app->post('/turmas-catequese-inscricoes', function($request, $response, $args) {
		
		$data = $request->getParsedBody();
		$inscricao = new TurmaCatequeseInscricao(db::getInstance());
		$inscricao->loadData(null, $data['inscricaoCatequeseId'], $data['turmaCatequeseId'], 
						 	 $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
							);
		$result = $inscricao->addTurmaCatequeseInscricao();
		return $response->write($result);
	})->add($middleAuthorization);


	// UPDATE
	$app->put('/turmas-catequese-inscricoes/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$inscricao = new TurmaCatequeseInscricao(db::getInstance());
		$inscricao->loadData($args['id'], $data['inscricaoCatequeseId'], $data['turmaCatequeseId'], 
							 $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
							);
		$result = $inscricao->saveTurmaCatequeseInscricao();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/turmas-catequese-inscricoes/{id}', function($request, $response, $args) {
		$inscricao = new TurmaCatequeseInscricao(db::getInstance());
		$inscricao->id = $args['id'];
		$result = $inscricao->deleteTurmaCatequeseInscricao();
		return $response->write($result);
	})->add($middleAuthorization);
?>