<?php
	
	require 'vendor/autoload.php';
	require 'model/db.php';
	require 'model/conversor.php';
	require 'model/util.php';

	//require 'db_connection.php';

	$app = new \Slim\App([
		'settings' => [
			'displayErrorDetails' => true
		]
	]);

	$app->get('/', function ($request, $response) {
		return $response->withStatus(401);
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

	/* CRUDS */
	require 'view/usuario.php';
	require 'view/pessoa.php';
	require 'view/estado.php';
	require 'view/municipio.php';
	require 'view/diocese.php';
	require 'view/paroquia.php';
	require 'view/comunidade.php';
	require 'view/catequista.php';
	require 'view/etapaCatequese.php';
	require 'view/escola.php';
	require 'view/turno.php';
	require 'view/turmaCatequese.php';
	require 'view/inscricaoCatequese.php';
	require 'view/situacaoInscricao.php';
	require 'view/situacaoDizimo.php';

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

	// ---------------------- INICIALIZACAO ----------------------

	$app->run();

?>