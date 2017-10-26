<?php
	require 'vendor/autoload.php';
	require 'model/db.php';
	require 'model/Pessoa.php';
	require 'model/Usuario.php';
	
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
					 	  $data['email'], $data['logradouro'], $data['numero'], $data['complemento'], 
						  $data['bairro'], $data['municipioId'], $data['numeroDizimo'], $data['comunidadeId'],
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
					 	  $data['email'], $data['logradouro'], $data['numero'], $data['complemento'], 
						  $data['bairro'], $data['municipioId'], $data['numeroDizimo'], $data['comunidadeId'],
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
				->write(json_encode(array('error'=> array('message' => 'Informacoes de login incorretas.' ))));
		} else {  
			return $response->withStatus(200)
				->withHeader('Content-Type', 'application/json;charset=utf-8')
				->write($result);
		}
	});

	

	$app->run();
	/*
	
	$app->put('/pessoas/:id','savePessoa');
	$app->delete('/pessoas/:id','deletePessoa');
	
	*/
	//$app->post('/usuarios/login', 'login')->setParams([$app]);

	/*
	$app->post('/usuarios/login', function () use ($app) {
		$json = $app->request->getBody();
		$data = json_decode($json, true); // parse the JSON into an assoc. array
		echo var_dump($data['usuario']['username']);
	});
	*/
	
	
	
	

	/* USUARIOS */
	/*
	function login($app) {

		//$usuario = json_decode();
		$json = $app->request->getBody();
		$usuario = json_decode($json, true); // parse the JSON into an assoc. array
		$username = $usuario['usuario']['username'];
		$password = $usuario['usuario']['password'];
		
	}
	*/
		//if (!empty($usuario->username) && !empty($usuario->password)) {
		/*
		$sql = "SELECT id, nome, usuario from ViewUsuario WHERE usuario = :usuario AND senha = :senha LIMIT 1";
		$conn = getConn();
		$passwordMD5 = md5($password);
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("usuario", $username);
		$stmt->bindParam("senha", $passwordMD5);
		$stmt->execute();
		if ($stmt->fetchColumn() > 0) {
			$arrayRetorno['user'] = $username;
			$arrayRetorno['token'] = bin2hex(openssl_random_pseudo_bytes(8)); // Gera um token aleatorio
			$tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
			updateToken($username, $arrayRetorno['token'], $tokenExpiration);
			echo json_encode($arrayRetorno);
		}
	

	}

	function updateToken($username, $token, $tokenExpiration) {
		if (!empty($username) && !empty($token) && !empty($tokenExpiration)) {
			$sql = 'UPDATE Usuario SET token = :token, tokenExpiracao = :tokenExpiracao WHERE usuario = :usuario;';
			$conn = getConn();
			$stmt = $conn->prepare($sql);
			$stmt->bindParam("usuario", $username);
			$stmt->bindParam("token", $token);
			$stmt->bindParam("tokenExpiracao", $tokenExpiration);
			$stmt->execute();
			return true;
		} else {
			return false;
		}
	}
	*/
	/* PESSOAS */


	/*
	$app->get('/hello/world', function () {
		echo "Hello";
	});

	
	$app->get('/', function() {
		echo "Hello World"; 
	});	
	
	*/
	


	
?>