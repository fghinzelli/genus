<?php
    require 'model/TurmaCatequese.php';

	// SELECT ALL
	$app->get('/turmas-catequese', function($request, $response, $args) {
		$turma = new TurmaCatequese(db::getInstance());
		$result = $turma->getTurmasCatequese();
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
	$app->get('/turmas-catequese/{id}', function($request, $response, $args) {
		$turma = new TurmaCatequese(db::getInstance());
		$result = $turma->getTurmaCatequese($args['id']);
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
	$app->post('/turmas-catequese', function($request, $response, $args) {
		
		$data = $request->getParsedBody();
		//return $data;
		$turma = new TurmaCatequese(db::getInstance());
		$turma->loadData(null, $data['etapaCatequeseId'], $data['comunidadeId'], $data['catequistaId'], $data['observacoes'],
						 $data['turnoId'], $data['diaSemana'], $data['horario'], $data['dataInicio'], $data['dataTermino'], 
						 $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						);
		$result = $turma->addTurmaCatequese();
		return $response->write($result);
	})->add($middleAuthorization);


	// UPDATE
	$app->put('/turmas-catequese/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$turma = new TurmaCatequese(db::getInstance());
		$turma->loadData($args['id'], $data['etapaCatequeseId'], $data['comunidadeId'], $data['catequistaId'], $data['observacoes'],
						 $data['turnoId'], $data['diaSemana'], $data['horario'], $data['dataInicio'], $data['dataTermino'], 
						 $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						);
		$result = $turma->saveTurmaCatequese();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/turmas-catequese/{id}', function($request, $response, $args) {
		$turma = new TurmaCatequese(db::getInstance());
		$turma->id = $args['id'];
		$result = $turma->deleteTurmaCatequese();
		return $response->write($result);
	})->add($middleAuthorization);
?>