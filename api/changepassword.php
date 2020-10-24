<?php
$auth = new AuthController;
$User = new UserController;
$data = json_decode(file_get_contents("php://input"));
$headers = apache_request_headers();
if(!isset($headers['token'])){
    exit(json_encode(["status"=>false,"message"=>"no token available"]));
}
$token = $headers['token'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($data->_token)) {
        exit(json_encode(["status" => false, "message" => "Authorization Required"]));
    }
    if (!isset($data->currentPassword)) {
        exit(json_encode(["status" => false, "message" => "Current Password Required"]));
    }

    if (!isset($data->newPassword)) {
        exit(json_encode(["status" => false, "message" => "New Password Required"]));
    }

    if (!isset($data->newPasswordConfirm)) {
        exit(json_encode(["status" => false, "message" => "Confirm New  Password"]));
    }
    $token = htmlspecialchars($token);
    $res = $auth->ValidateToken($token);
    if ($res["status"]) {
        $userID = $res["userID"];
        $current = htmlspecialchars(trim($data->currentPassword));
        $new = htmlspecialchars(trim($data->newPassword));
        $confirm = htmlspecialchars(trim($data->newPasswordConfirm));
        exit(json_encode($User->UpdatePassword($userID, $current, $new, $confirm)));

    } else {
        exit(json_encode($res));
    }

} else {
    exit(json_encode(["status" => false, "message" => "Method Not Allowed"]));
}
