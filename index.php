<?php
    //JWT slim/slim-skeleton firebase/php-jwt
    require_once './vendor/autoload.php';
    require_once './providers/seguridad.php';

    //SLIM
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    $app = new \Slim\App;

    //VARIABLES DE CONFIG
    require_once './config.php';

    //CONTROLLER
    require_once './controller/auth.php';
    require_once './controller/clases.php';


    //URL
    $mw = function ($request, $response, $next) {

        $headers         = ($request->getHeader('token') == null) ? array(''): $request->getHeader('token');
        $arrayPrincipal  = array();
        $array           = array(); 
      
        $seguridad       = new protegeRuta();
        $validacionToken = $seguridad->validarToken($headers[0], key);
        $json            = json_decode($validacionToken);
        array_push($array, $json);  

        $error = true;
        foreach($array as $obj){
            $error = $obj->error;  
        }

        if(!$error) {
            $response = $next($request, $response);
        } else {
            $arrayPrincipal['error']         = true;
            $arrayPrincipal['err']           = 'token invalido';
            $arrayPrincipal['data']          = [];
            $arrayPrincipal['rowsaffected']  = -1;

            $response = $response->withJson($arrayPrincipal, 500);
        }
        return $response;
    };

    //mensaje de bienvenida
    $app->get('/', function($request, $response, $args) {
        $response->getBody()->write("Bienvenidos a la Api!");
        return $response;
    });
    //login
    $app->post('/auth', 'login');

    //test
    $app->group('/test', function () use ($app) {
        // Version group
        $app->group('/v1', function () use ($app) {
          $app->get('/{categoria}', 'insCat');
        });
    })->add($mw);

    $app->run();
?>