<?php
    require 'model/SituacaoDizimo.php';

	// SELECT ALL
	$app->get('/situacao-dizimo', function($request, $response, $args) {
		$situacao = new SituacaoDizimo(db::getInstance());
		$result = $situacao->getSituacoesDizimo();
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