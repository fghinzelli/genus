<?php
    require 'model/InscricaoCatequese.php';

	// SELECT ALL
	$app->get('/inscricoes-catequese', function($request, $response, $args) {
		$inscricao = new InscricaoCatequese(db::getInstance());
		$result = $inscricao->getInscricoesCatequese();
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

	// SELECT ALL BY IDETAPA
	$app->get('/inscricoes-catequese/etapa/{idEtapa}', function($request, $response, $args) {
		$inscricao = new InscricaoCatequese(db::getInstance());
		$result = $inscricao->getInscricoesCatequeseByEtapa($args['idEtapa']);
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

	// SELECT BY id
	$app->get('/inscricoes-catequese/{id}', function($request, $response, $args) {
		$inscricao = new InscricaoCatequese(db::getInstance());
		$result = $inscricao->getInscricaoCatequese($args['id']);
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

	

	// INSERT
	$app->post('/inscricoes-catequese', function($request, $response, $args) {
		
		$data = $request->getParsedBody();
		//return $data;
		$inscricao = new InscricaoCatequese(db::getInstance());
		$inscricao->loadData(null, $data['pessoaId'], $data['etapaCatequeseId'], $data['escolaId'], $data['etapaEscolaId'],
							$data['turmaId'], $data['observacoes'], $data['situacaoInscricaoId'], $data['turnoId'], 
							$data['situacaoDizimoId'], $data['comunidadeId'], $data['dataInscricao'],
							$data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId'], $data['anoLetivoId']
						  );
		$result = $inscricao->addInscricaoCatequese();
		return $response->write($result);
	})->add($middleAuthorization);


	// UPDATE
	$app->put('/inscricoes-catequese/{id}', function($request, $response, $args) {
		$data = $request->getParsedBody();
		$inscricao = new InscricaoCatequese(db::getInstance());
		$inscricao->loadData($args['id'], $data['pessoaId'], $data['etapaCatequeseId'], $data['escolaId'], $data['etapaEscolaId'],
							  $data['turmaId'], $data['observacoes'], $data['situacaoInscricaoId'], $data['turnoId'], 
							  $data['situacaoDizimoId'], $data['comunidadeId'], $data['dataInscricao'],
							  $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId'], $data['anoLetivoId']
							);
		$result = $inscricao->saveInscricaoCatequese();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/inscricoes-catequese/{id}', function($request, $response, $args) {
		$inscricao = new InscricaoCatequese(db::getInstance());
		$inscricao->id = $args['id'];
		$result = $inscricao->deleteInscricaoCatequese();
		return $response->write($result);
	})->add($middleAuthorization);
?>