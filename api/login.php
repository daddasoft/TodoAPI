<?php
$User = new UserController;
$auth = new AuthController;
$data = json_decode(file_get_contents("php://input"));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($data->username)) {
        exit(json_encode(["status" => false,"field"=>"username" ,"message" => "Username Not Passed"]));
    } elseif (!isset($data->password)) {
        exit(json_encode(["status" => false,"field"=>"password", "message" => "Password Not Passed"]));
    } else {
        $username = htmlspecialchars($data->username);
        $password = htmlspecialchars($data->password);
        $res = $User->LoginController($username, $password);
        if ($res["status"]) {
            $token = $auth->GeneratedToken();
            $userId = $res["data"]["UserID"];
            $auth->DeleteToken( $userId);
            if ($auth->PutToken($userId, $token)) {
                $expire = time() * 40 * 7 * 5555;
                $cc = "Set-Cookie: _token=$token";
                header($cc);
                exit(json_encode(["status" => true, "access_token" => $token,"user"=>$res["data"]]));
            } else {
                exit(json_encode(["status" => false, "message" => "Error While Generating The Token"]));
            }
        } else {
            exit(json_encode($res));
        }
    }
} else {
    exit(json_encode(["status" => false, "message" => "Method Not Allowed"]));
}
