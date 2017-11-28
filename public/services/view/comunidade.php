<?php
	require 'model/Comunidade.php';

    // SELECT ALL
	$app->get('/comunidades', function($request, $response, $args) {
		$comunidade = new Comunidade(db::getInstance());
		$result = $comunidade->getComunidades();
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

	// SELECT ONE
	$app->get('/comunidades/{id}', function($request, $response, $args) {
		$comunidade = new Comunidade(db::getInstance());
		$result = $comunidade->getComunidade($args['id']);
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


	// ADD
	$app->post('/comunidades', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$comunidade = new Comunidade(db::getInstance());
		$comunidade->loadData(null, $data['nome'], $data['paroquiaId'], $data['dataFundacao'],
							  $data['responsavelCatequese'], $data['email'], $data['telefone'], $data['logradouro'],
							  $data['numero'], $data['complemento'], $data['bairro'], $data['municipioId'], $data['cep'],
						   	  $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						  	  );
		$result = $comunidade->addComunidade();
		return $response->write($result);
	})->add($middleAuthorization);

	// UPDATE
	$app->put('/comunidades/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$comunidade = new Comunidade(db::getInstance());
		$comunidade->loadData($args['id'], $data['nome'], $data['paroquiaId'], $data['dataFundacao'],
							  $data['responsavelCatequese'], $data['email'], $data['telefone'], $data['logradouro'],
							  $data['numero'], $data['complemento'], $data['bairro'], $data['municipioId'], $data['cep'],
		   					  $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
							  );
		$result = $comunidade->saveComunidade();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/comunidades/{id}', function($request, $response, $args) {
		$comunidade = new Comunidade(db::getInstance());
		$comunidade->id = $args['id'];
		$result = $comunidade->deleteComunidade();
		return $response->write($result);
	})->add($middleAuthorization);
?>