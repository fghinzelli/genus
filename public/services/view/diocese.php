<?php
    require 'model/Diocese.php';
    
    // SELECT ALL
    $app->get('/dioceses', function($request, $response, $args) {
        $diocese = new Diocese(db::getInstance());
        $result = $diocese->getDioceses();
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