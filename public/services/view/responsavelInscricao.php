<?php
    require 'model/ResponsavelInscricao.php';

	// SELECT ALL OF A TURMA
	$app->get('/responsaveis/inscricao/{idInscricao}', function($request, $response, $args) {
		$responsaveis = new ResponsavelInscricao(db::getInstance());
		$result = $responsaveis->getResponsaveisInscricao($args['idInscricao']);
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
	$app->post('/responsaveis', function($request, $response, $args) {
		
		$data = $request->getParsedBody();
		$responsavel = new ResponsavelInscricao(db::getInstance());
		$responsavel->loadData(null, $data['inscricaoCatequeseId'], $data['pessoaResponsavelId'], 
							 $data['observacoes'], $data['parentescoId'],  
						 	 $data['status'], $data['dataUltimaAlteracao'], $data['usuarioUltimaAlteracaoId']
							);
		$result = $responsavel->addResponsavelInscricao();
		return $response->write($result);
	})->add($middleAuthorization);

	// DELETE
	$app->delete('/responsaveis/{id}', function($request, $response, $args) {
		$responsavel = new ResponsavelInscricao(db::getInstance());
		$responsavel->id = $args['id'];
		$result = $responsavel->deleteResponsavelInscricao();
		return $response->write($result);
	})->add($middleAuthorization);
?>