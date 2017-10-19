<?php
	require 'vendor/autoload.php';

	$app = new \Slim\Slim();
	
	/*
	$app->get('/hello/{name}', function ($request, $response, $args) {
    	return $response->write("Hello " . $args['name']);
	});
	*/
	$app->get('/', function() {
		echo "Hello World"; 
	});	

	$app->run();
?>
