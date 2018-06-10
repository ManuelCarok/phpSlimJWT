<?php
    function insCat($request, $response, $args) {
		$params = array();
		$params['test'] = $args['categoria'];
        return $response->withJson($params, 200);   
    }
?>
