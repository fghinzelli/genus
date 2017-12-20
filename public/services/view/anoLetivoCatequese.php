<?php

	require 'model/AnoLetivoCatequese.php';

	// SELECT ALL
	$app->get('/anos-letivos-catequese', function($request, $response, $args) {
		$anosLetivosCatequese = new AnoLetivoCatequese(db::getInstance());
		$result = $anosLetivosCatequese->getAnosLetivos();
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