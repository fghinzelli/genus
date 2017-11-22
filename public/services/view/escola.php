<?php
    require 'model/Escola.php';

	// SELECT ALL
	$app->get('/escolas', function($request, $response, $args) {
		$escola = new Escola(db::getInstance());
		$result = $escola->getEscola();
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