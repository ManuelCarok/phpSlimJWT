<?php
    function login($request, $response) {
        $payload = array();
		$payload['user'] = 'manuel';
		$payload['pass'] = '123';
		
        $token = new protegeRuta();
        $result = $token->generarToken($payload,key,time);
        return $response->withJson($result, 200);   
    }
?>