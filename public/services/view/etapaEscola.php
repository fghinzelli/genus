<?php
    require 'model/EtapaEscola.php';

	// SELECT ALL
	$app->get('/etapas-escola', function($request, $response, $args) {
		$etapaEscola = new EtapaEscola(db::getInstance());
		$result = $etapaEscola->getEtapasEscola();
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