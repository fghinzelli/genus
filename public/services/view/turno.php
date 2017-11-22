<?php

	require 'model/Turno.php';

	// SELECT ALL
	$app->get('/turnos', function($request, $response, $args) {
		$turno = new Turno(db::getInstance());
		$result = $turno->getTurnos();
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