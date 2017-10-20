<?php
	require 'vendor/autoload.php';

	$app = new \Slim\Slim();
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	$app->get('/', function () {
		echo "Genus API ";
	});
	
	$app->get('/pessoas', 'getPessoas');
	$app->get('/pessoas/:id','getPessoa');
	$app->post('/pessoas','addPessoa');
	$app->put('/pessoas/:id','savePessoa');
	$app->delete('/pessoas/:id','deletePessoa');

	$app->run();
	
	function getConn() {
		return new PDO('mysql:host=localhost;dbname=genus',
					   'root',
					   'sys@dmin',
					    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
		);
	}

	/* PESSOAS */

	function getPessoas() {
		$stmt = getConn()->query("SELECT * FROM Pessoa");
		$pessoas = $stmt->fetchAll(PDO::FETCH_OBJ);
		echo "{\"categorias\":" . json_encode($pessoas) . "}";
	}

	function addPessoa() {
		$request = \Slim\Slim::getInstance()->request();
		$pessoa = json_decode($request->getBody());
		$sql = "INSERT INTO Pessoa (`nome`, `sexo`, `dataNascimento`, `telefone1`, `telefone2`, `cpf`, `rg`, `email`, `logradouro`, `numero`, `complemento`, `bairro`, `municipioId`, `dataCadastramento`, `status`) 
				VALUES (:nome, :sexo, :dataNascimento, :telefone1, :telefone2, :cpf, :rg, :email, :logradouro, :numero, :complemento, :bairro, :municipioId, :dataCadastramento, :status) ";
		$conn = getConn();
		$stmt = $conn->prepare($sql);
		$stmt->bindParam("nome",$pessoa->nome);
		$stmt->bindParam("sexo",$pessoa->sexo);
		$stmt->bindParam("dataNascimento",$pessoa->dataNascimento);
		$stmt->bindParam("telefone1",$pessoa->telefone1);
		$stmt->bindParam("telefone2",$pessoa->telefone2);
		$stmt->bindParam("cpf",$pessoa->cpf);
		$stmt->bindParam("rg",$pessoa->rg);
		$stmt->bindParam("email",$pessoa->email);
		$stmt->bindParam("logradouro",$pessoa->logradouro);
		$stmt->bindParam("numero",$pessoa->numero);
		$stmt->bindParam("complemento",$pessoa->complemento);
		$stmt->bindParam("bairro",$pessoa->bairro);
		$stmt->bindParam("municipioId",$pessoa->municipioId);
		$stmt->bindParam("dataCadastramento",$pessoa->dataCadastramento);
		$stmt->bindParam("status",$pessoa->status);
		$stmt->execute();
		$produto->id = $conn->lastInsertId();
		echo json_encode($produto);
	}
	

	function getPessoa($id)
	{
	  $conn = getConn();
	  $sql = "SELECT * FROM Pessoa WHERE id=:id";
	  $stmt = $conn->prepare($sql);
	  $stmt->bindParam("id",$id);
	  $stmt->execute();
	  $pessoa = $stmt->fetchObject();
	
	  //municipio
	  $sql = "SELECT * FROM Municipio WHERE id=:id";
	  $stmt = $conn->prepare($sql);
	  $stmt->bindParam("id",$pessoa->municipioId);
	  $stmt->execute();
	  $pessoa->municipio =  $stmt->fetchObject();
	
	  echo json_encode($pessoa);
	}

	function savePessoa($id)
	{
	  $request = \Slim\Slim::getInstance()->request();
	  $pessoa = json_decode($request->getBody());
	  $sql = "UPDATE Pessoa SET nome=:nome,sexo=:sexo,dataNascimento=:dataNascimento,telefone1=:telefone1,
	  		  telefone2=:telefone2,cpf=:cpf,rg=:rg,email=:email,logradouro=:logradouro,numero=:numero,
			  complemento=:complemento,bairro=:bairro,municipioId=:municipioId,dataCadastramento=:dataCadastramento,status=:status
	  		  WHERE id=:id";
	  $conn = getConn();
	  $stmt = $conn->prepare($sql);
	  $stmt->bindParam("nome",$pessoa->nome);
	  $stmt->bindParam("sexo",$pessoa->sexo);
	  $stmt->bindParam("dataNascimento",$pessoa->dataNascimento);
	  $stmt->bindParam("telefone1",$pessoa->telefone1);
	  $stmt->bindParam("telefone2",$pessoa->telefone2);
	  $stmt->bindParam("cpf",$pessoa->cpf);
	  $stmt->bindParam("rg",$pessoa->rg);
	  $stmt->bindParam("email",$pessoa->email);
	  $stmt->bindParam("logradouro",$pessoa->logradouro);
	  $stmt->bindParam("numero",$pessoa->numero);
	  $stmt->bindParam("complemento",$pessoa->complemento);
	  $stmt->bindParam("bairro",$pessoa->bairro);
	  $stmt->bindParam("municipioId",$pessoa->municipioId);
	  $stmt->bindParam("dataCadastramento",$pessoa->dataCadastramento);
	  $stmt->bindParam("status",$pessoa->status);
	  $stmt->bindParam("id",$id);
	  $stmt->execute();
	  echo json_encode($pessoa);
	
	}
	
	function deletePessoa($id)
	{
	  $sql = "DELETE FROM Pessoa WHERE id=:id";
	  $conn = getConn();
	  $stmt = $conn->prepare($sql);
	  $stmt->bindParam("id",$id);
	  $stmt->execute();
	  echo "{'message':'Pessoa apagada'}";
	}


	/*
	$app->get('/hello/world', function () {
		echo "Hello";
	});

	
	$app->get('/', function() {
		echo "Hello World"; 
	});	
	
	*/
	


	
?>
