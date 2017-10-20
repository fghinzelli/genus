<?php
	require 'vendor/autoload.php';

	$app = new \Slim\Slim();
	$app->response()->header('Content-Type', 'applicattion/json;charset=utf-8');
	$app->get('/', function () {
		echo "Genus API ";
	});
	
	$app->get('/pessoas', 'getPessoas');
	// TODO: Setar aqui as demais rotas da API

	$app->run();
	
	function getConn() {
		return new PDO('mysql:host=localhost;dbname=genus',
		'root',
		'sys@dmin',
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
		);
	}

	function getPessoas() {
		$stmt = getConn()->query("SELECT * FROM Pessoa");
		$pessoas = $stmt->fetchAll(PDO::FETCH_OBJ);
		echo "{\"categorias\":" . json_encode($pessoas) . "}";
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
