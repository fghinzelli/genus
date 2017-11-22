<?php
	require 'model/SituacaoInscricao.php';

    // SELECT ALL
	$app->get('/situacao-inscricao', function($request, $response, $args) {
		$situacao = new SituacaoInscricao(db::getInstance());
		$result = $situacao->getSituacoesInscricao();
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