<?php
    use Firebase\JWT\JWT;
	use Firebase\JWT\ExpiredException;
	use Firebase\JWT\SignatureInvalidException;
    
    class protegeRuta {

        public function __construct() {

        }

        public function generarToken($payload, $keys, $times) {
            $time = time();
            $key = $keys;

            $token = array(
                'iat' => $time, // Tiempo que inició el token
                'exp' => $time + (60*$times), // Tiempo que expirará el token (+1 hora)
                'data' => $payload // información del usuario
            );

            $jwt = JWT::encode($token, $key);

            return array('token' => $jwt);
        }

        public function validarToken($jwt, $key) {
            $array = array();
            $array['error'] = false;
            $array['data']  = [];
            try {
                $data = JWT::decode($jwt, $key, array('HS256'));
                $array['error'] = false;
                $array['data']  = $data;
                return json_encode($array);

            } catch(ExpiredException $e){
				$array['error'] = true;
                $array['data']  = [];
                return json_encode($array);
			
			} catch (SignatureInvalidException $e) {
				$array['error'] = true;
                $array['data']  = [];
                return json_encode($array);
				
			} catch (Exception $e) {
                $array['error'] = true;
                $array['data']  = [];
                return json_encode($array);
            }
        }
    }
?>