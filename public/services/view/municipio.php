<?php
    require 'model/Municipio.php';

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
?>
