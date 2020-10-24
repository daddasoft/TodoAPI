<?php
$auth = new AuthController;
$data = json_decode(file_get_contents("php://input"));
$token = htmlspecialchars($data->_token);
// $token = htmlspecialchars($data->_token);
$res = $auth->ValidateToken($token);

if($res["status"]){
	echo json_encode($res);
}
else{
	http_response_code(401);
	echo json_encode($res);
}