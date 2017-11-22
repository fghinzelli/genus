<?php
    require 'model/EtapaCatequese.php';

	// SELECT ALL
	$app->get('/etapas-catequese', function($request, $response, $args) {
		$etapaCatequese = new EtapaCatequese(db::getInstance());
		$result = $etapaCatequese->getEtapasCatequese();
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