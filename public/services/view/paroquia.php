<?php
    require 'model/Paroquia.php';

    // SELECT ALL
	$app->get('/paroquias', function($request, $response, $args) {
		$paroquia = new Paroquia(db::getInstance());
		$result = $paroquia->getParoquias();
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
	$app->get('/paroquias/{id}', function($request, $response, $args) {
		$paroquia = new Paroquia(db::getInstance());
		$result = $paroquia->getParoquia($args['id']);
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
	$app->post('/paroquias', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$paroquia = new Paroquia(db::getInstance());
		$paroquia->loadData(null, $data['nome'], $data['cnpj'], $data['email'], $data['telefone'], $data['logradouro'],
                            $data['numero'], $data['complemento'], $data['bairro'], $data['municipioId'], $data['cep'],
                            $data['dioceseId'], $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
                            );
		$result = $paroquia->addParoquia();
		return $response->write($result);
    })->add($middleAuthorization);
    
    // UPDATE
	$app->put('/paroquias/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$paroquia = new Paroquia(db::getInstance());
		$paroquia->loadData($args['id'], $data['nome'], $data['cnpj'], $data['email'], $data['telefone'], $data['logradouro'],
                            $data['numero'], $data['complemento'], $data['bairro'], $data['municipioId'], $data['cep'],
                            $data['dioceseId'], $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
                            );
		$result = $paroquia->saveParoquia();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/paroquias/{id}', function($request, $response, $args) {
		$paroquia = new Paroquia(db::getInstance());
		$paroquia->id = $args['id'];
		$result = $paroquia->deleteParoquia();
		return $response->write($result);
	})->add($middleAuthorization);
?>