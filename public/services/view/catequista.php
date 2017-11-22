<?php
    require 'model/Catequista.php';

	// SELECT ALL
	$app->get('/catequistas', function($request, $response, $args) {
		$catequista = new Catequista(db::getInstance());
		$result = $catequista->getCatequistas();
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
	$app->get('/catequistas/{id}', function($request, $response, $args) {
		$catequista = new Catequista(db::getInstance());
		$result = $catequista->getCatequista($args['id']);
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
	$app->post('/catequistas', function($request, $response, $args) {
		
		$data = $request->getParsedBody();
		//return $data;
		$catequista = new Catequista(db::getInstance());
		$catequista->loadData(null, $data['pessoaId'], $data['comunidadeId'], $data['dataInicio'],
						  $data['observacoes'], $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						  );
		$result = $catequista->addCatequista();
		return $response->write($result);
	})->add($middleAuthorization);
	
	// UPDATE
	$app->put('/catequistas/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$catequista = new Catequista(db::getInstance());
		$catequista->loadData($args['id'], $data['pessoaId'], $data['comunidadeId'], $data['dataInicio'],
							  $data['observacoes'], $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
							  );
		$result = $catequista->saveCatequista();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/catequistas/{id}', function($request, $response, $args) {
		$catequista = new Catequista(db::getInstance());
		$catequista->id = $args['id'];
		$result = $catequista->deleteCatequista();
		return $response->write($result);
	})->add($middleAuthorization);
?>