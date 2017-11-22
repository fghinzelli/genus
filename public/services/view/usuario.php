<?php
    require 'model/Usuario.php';

    // SELECT ALL
	$app->get('/usuarios', function($request, $response, $args) {
		$usuario = new Usuario(db::getInstance());
		$result = $usuario->getUsuarios();
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
	$app->get('/usuarios/{id}', function($request, $response, $args) {
		$usuario = new Usuario(db::getInstance());
		$result = $usuario->getUsuario($args['id']);
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
	$app->post('/usuarios', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$usuario = new Usuario(db::getInstance());
		$usuario->loadData(null,
						  getAtt('username', $data), getAtt('senha', $data), getAtt('pessoaId', $data),
						  getAtt('token', $data), getAtt('tokenExpiracao', $data), getAtt('status', $data),
						  getAtt('paroquiaSelecionada', $data), getAtt('dataUltimaAlteracao', $data), getAtt('usuarioUltimaAlteracaoId', $data)
						  );
		$result = $usuario->addUsuario();
		return $result;
	})->add($middleAuthorization);

	// UPDATE
	$app->put('/usuarios/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$usuario = new Usuario(db::getInstance());
		$usuario->loadData($args['id'], getAtt('username', $data), getAtt('senha', $data), getAtt('pessoaId', $data),
							getAtt('token', $data), getAtt('tokenExpiracao', $data), getAtt('status', $data),
							getAtt('paroquiaSelecionada', $data), getAtt('dataUltimaAlteracao', $data), getAtt('usuarioUltimaAlteracaoId', $data)
							);
		$result = $usuario->saveUsuario();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/usuarios/{id}', function($request, $response, $args) {
		$usuario = new Usuario(db::getInstance());
		$usuario->id = $args['id'];
		$result = $usuario->deleteUsuario();
		return $response->write($result);
	})->add($middleAuthorization);

?>