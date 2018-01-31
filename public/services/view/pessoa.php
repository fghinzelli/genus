<?php
	require 'model/Pessoa.php';
	
    // SELECT ALL
	$app->get('/pessoas', function($request, $response, $args) {
		$pessoa = new Pessoa(db::getInstance());
		$result = $pessoa->getPessoas();
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
	$app->get('/pessoas/{id}', function($request, $response, $args) {
		$pessoa = new Pessoa(db::getInstance());
		$result = $pessoa->getPessoa($args['id']);
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
	$app->post('/pessoas', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$pessoa = new Pessoa(db::getInstance());
		$pessoa->loadData(null, 
						  getAtt('nome', $data), getAtt('sexo', $data), getAtt('nomePai', $data),
						  getAtt('nomeMae', $data), getAtt('dataNascimento', $data), getAtt('telefone1', $data),
						  getAtt('telefone2', $data), getAtt('telefone3', $data), getAtt('cpf', $data), getAtt('rg', $data),
						  getAtt('rgEmissor', $data), getAtt('rgUF', $data), getAtt('passaporte', $data),
						  getAtt('nacionalidade', $data), getAtt('email', $data), getAtt('logradouro', $data),
						  getAtt('numero', $data), getAtt('complemento', $data), getAtt('bairro', $data),
						  getAtt('municipioId', $data), getAtt('cep', $data), getAtt('numeroDizimo', $data),
						  getAtt('comunidadeId', $data), getAtt('observacoes', $data), getAtt('batizado', $data), getAtt('localBatismo', $data), getAtt('dataBatismo', $data),
						  getAtt('primeiraEucaristia', $data), getAtt('localPrimeiraEucaristia', $data), getAtt('dataPrimeiraEucaristia', $data),
						  getAtt('status', $data), getAtt('dataUltimaAlteracao', $data), getAtt('usuarioUltimaAlteracaoId', $data)
						  );
		$result = $pessoa->addPessoa();
		return $result;
	})->add($middleAuthorization);
	

	// UPDATE
	$app->put('/pessoas/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$pessoa = new Pessoa(db::getInstance());
		$pessoa->loadData($args['id'], $data['nome'], $data['sexo'], $data['nomePai'], $data['nomeMae'],
						  $data['dataNascimento'], $data['telefone1'], $data['telefone2'], $data['telefone3'], $data['cpf'], $data['rg'], 
						  $data['rgEmissor'], $data['rgUF'], $data['passaporte'], $data['nacionalidade'], 
						  $data['email'], $data['logradouro'], $data['numero'], $data['complemento'], 
						  $data['bairro'], $data['municipioId'], $data['cep'], $data['numeroDizimo'], $data['comunidadeId'],
						  $data['observacoes'], $data['batizado'], $data['localBatismo'], $data['dataBatismo'], $data['primeiraEucaristia'],
						  $data['localPrimeiraEucaristia'], $data['dataPrimeiraEucaristia'], $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						);
		$result = $pessoa->savePessoa();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/pessoas/{id}', function($request, $response, $args) {
		$pessoa = new Pessoa(db::getInstance());
		$pessoa->id = $args['id'];
		$result = $pessoa->deletePessoa();
		return $response->write($result);
	})->add($middleAuthorization);
?>