<?php
$auth = new AuthController;
$todo = new TodoController;
$data = json_decode(file_get_contents("php://input"));
$headers = apache_request_headers();
if(!isset($headers['token'])){
    exit(json_encode(["status"=>false,"message"=>"no token available"]));
}
$token = $headers['token'];
$res = $auth->ValidateToken($token);
if(!$res["status"]){
    exit(json_encode($res));
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($res["status"]) {
        $userID = $res["data"]["UserID"];
        $response = $todo->getTodo($userID);
        exit(json_encode($response));
    } else {
        exit(json_encode($res));
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($data->content)) {
        http_response_code(400);
        exit(json_encode(["status" => false, "message" => "Content Field Requited"]));
    }
    exit(json_encode($todo->AddTodo($res["data"]["UserID"], $data->content)));
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    if (!isset($data->todoUID)) {
        exit(json_encode(["status" => false, "message" => "Todo id not passed"]));
    }
    if (!isset($data->newContent)) {
        exit(json_encode(["status" => false, "message" => "new Content Can't Be Empty"]));
    }
    if (strlen(trim($data->newContent)) < 5) {
        http_response_code(400);
        exit(json_encode(["status" => false, "message" => "new Content Is Too Short"]));
    }
    $todoUID = htmlspecialchars($data->todoUID);
    $newContent = htmlspecialchars($data->newContent);
    exit(json_encode($todo->ModifyTodo($res["data"]["UserID"], $todoUID, $newContent)));
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    if (!isset($data->todoUID)) {
        exit(json_encode(["status" => false, "message" => "Todo id not passed"]));
    }
    $todoUID = htmlspecialchars(trim($data->todoUID));
    exit(json_encode($todo->DeleteOneTodo($res["data"]["UserID"], $todoUID)));
} elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    exit(json_encode($todo->ClearUserTodo($res["userID"])));
} else {
    exit(json_encode(["status" => false, "message" => "Method Not Allowed"]));
}
