<?php
$User = new UserController;
$data = json_decode(file_get_contents("php://input"));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($data->username)) {
        exit(json_encode(["status" => false, "message" => "Username Not Passed"]));
    } elseif (!isset($data->email)) {
        exit(json_encode(["status" => false, "message" => "Email Not Passed"]));
    } elseif (!isset($data->password)) {
        exit(json_encode(["status" => false, "message" => "Password Not Passed"]));
    } elseif (!isset($data->confirmPassword)) {
        exit(json_encode(["status" => false, "message" => "Confirm Password Not Passed"]));
    } else {
        $username = htmlspecialchars($data->username);
        $password = htmlspecialchars($data->password);
        $confirmPassword = htmlspecialchars($data->confirmPassword);
        $email = htmlspecialchars($data->email);
        $res = $User->RegisterController($username, $email, $password, $confirmPassword);
        exit(json_encode($res));
    }

} else {
    exit(json_encode(["status" => false, "message" => "Method Not Allowed"]));
}
