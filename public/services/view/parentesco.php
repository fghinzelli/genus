<?php
    require 'model/Parentesco.php';

	// SELECT ALL
	$app->get('/parentescos', function($request, $response, $args) {
		$parentesco = new Parentesco(db::getInstance());
		$result = $parentesco->getParentescos();
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
	$app->get('/parentescos/{id}', function($request, $response, $args) {
		$parentesco = new Parentesco(db::getInstance());
		$result = $parentesco->getParentesco($args['id']);
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