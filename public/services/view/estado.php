<?php
	require 'model/Estado.php';
	
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

?>