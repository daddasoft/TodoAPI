<?php
$User = new UserController;
$auth = new AuthController;
$data = json_decode(file_get_contents("php://input"));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($data->username)) {
         http_response_code(400);
        exit(json_encode(["status" => false, "message" => "Username Not Passed"]));
    } elseif (!isset($data->email)) {
        http_response_code(400);
        exit(json_encode(["status" => false, "message" => "Email Not Passed"]));
    } elseif (!isset($data->password)) {
        http_response_code(400);
        exit(json_encode(["status" => false, "message" => "Password Not Passed"]));
    } elseif (!isset($data->confirmPassword)) {
        http_response_code(400);
        exit(json_encode(["status" => false, "message" => "Confirm Password Not Passed"]));
    } else {
        $username = htmlspecialchars($data->username);
        $password = htmlspecialchars($data->password);
        $confirmPassword = htmlspecialchars($data->confirmPassword);
        $email = htmlspecialchars($data->email);
        $res = $User->RegisterController($username, $email, $password, $confirmPassword);
        if ($res["status"]) {
            $res2 = $User->LoginController($username, $password);
            $token = $auth->GeneratedToken();
            $userId = $res2["data"]["UserID"];
            $auth->DeleteToken($userId);
            if ($auth->PutToken($userId, $token)) {
                $expire = time() * 40 * 7 * 5555;
                $cc = "Set-Cookie: _token=$token";
                header($cc);
                exit(json_encode(["status" => true, "access_token" => $token, "user" => $res2["data"]]));
            } else {
                http_response_code(400);
                exit(json_encode(["status" => false, "message" => "Error While Generating The Token"]));
            }
        }
        http_response_code(400);
        exit(json_encode($res));
    }
} else {
    http_response_code(405);
    exit(json_encode(["status" => false, "message" => "Method Not Allowed"]));
}
