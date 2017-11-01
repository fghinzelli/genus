<?php
	require 'vendor/autoload.php';
	require 'model/db.php';
	require 'model/Pessoa.php';
	require 'model/Usuario.php';
	require 'model/Estado.php';
	require 'model/Municipio.php';
	
	//require 'db_connection.php';

	$app = new \Slim\App([
		'settings' => [
			'displayErrorDetails' => true
		]
	]);

	$app->get('/', function ($request, $response) {
		echo "Genus API ";
	});

	// Verifica se o usuario possui autorizacao
	$middleAuthorization = function ($request, $response, $next) {
		if ($request->hasHeader('Authorization')) {
			//$token = explode('Basic ', $request->getHeader('Authorization')[0])[1];
			$token = $request->getHeader('Authorization')[0];
			$user = new Usuario(db::getInstance());
			$result = $user->isValidToken($token);
			if($result === true) {
				$response = $next($request, $response);
				return $response;
			} else {
				return $response->withStatus(401);
			}
		} else {
			return $response->withStatus(401);
		}
	};

	/* CRUD PESSOAS */

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
		$pessoa->loadData(null, $data['nome'], $data['sexo'], $data['nomePai'], $data['nomeMae'],
						  $data['dataNascimento'], $data['telefone1'], $data['telefone2'], $data['cpf'], $data['rg'], 
						  $data['rgEmissor'], $data['rgUF'], $data['passaporte'], $data['nacionalidade'], 
						  $data['email'], $data['logradouro'], $data['numero'], $data['complemento'], 
						  $data['bairro'], $data['municipioId'], $data['cep'], $data['numeroDizimo'], $data['comunidadeId'],
						  $data['observacoes'], $data['batizado'], $data['localBatismo'], $data['primeiraEucaristia'],
						  $data['localPrimeiraEucaristia'], $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
						  );
		$result = $pessoa->addPessoa();
		return $response->write($result);
	})->add($middleAuthorization);
	
	// UPDATE
	$app->put('/pessoas/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$pessoa = new Pessoa(db::getInstance());
		$pessoa->loadData($args['id'], $data['nome'], $data['sexo'], $data['nomePai'], $data['nomeMae'],
						  $data['dataNascimento'], $data['telefone1'], $data['telefone2'], $data['cpf'], $data['rg'], 
						  $data['rgEmissor'], $data['rgUF'], $data['passaporte'], $data['nacionalidade'], 
						  $data['email'], $data['logradouro'], $data['numero'], $data['complemento'], 
						  $data['bairro'], $data['municipioId'], $data['cep'], $data['numeroDizimo'], $data['comunidadeId'],
						  $data['observacoes'], $data['batizado'], $data['localBatismo'], $data['primeiraEucaristia'],
						  $data['localPrimeiraEucaristia'], $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
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


	$app->post('/login', function($request, $response, $args) { 
		$data = $request->getParsedBody();
		$usuario = new Usuario(db::getInstance());    
		$result = $usuario->checkUser($data['username'], $data['password']);
		if($result === false) {
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write(json_encode(array('error'=> array('message' => 'Informações incorretas!' ))));
		} else {  
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write($result);
		}
	});

	/* ESTADOS */

	// SELECT ALL
	$app->get('/estados', function($request, $response, $args) {
		$estado = new Estado(db::getInstance());
		$result = $estado->getEstados();
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

	/* ESTADOS */

	// SELECT BY UF
	$app->get('/municipios/{uf}', function($request, $response, $args) {
		$municipio = new Municipio(db::getInstance());
		$result = $municipio->getMunicipio($args['uf']);
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


	$app->run();

?>