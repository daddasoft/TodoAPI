<?php
$auth = new AuthController;
$todo = new TodoController;
$data = json_decode(file_get_contents("php://input"));
if (!isset($data->_token)) {
    exit(json_encode(["status" => false, "message" => "Authorization Required"]));
}
$token = htmlspecialchars($data->_token);
$res = $auth->ValidateToken($token);
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if ($res["status"]) {
        $userID = $res["userID"];
        $response = $todo->getTodo($userID);
        exit(json_encode($response));
    } else {
        exit(json_encode($res));
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($data->content)) {
        exit(json_encode(["status" => false, "message" => "Content Field Requited"]));
    }
    exit(json_encode($todo->AddTodo($res["userID"], $data->content)));
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    if (!isset($data->todoUID)) {
        exit(json_encode(["status" => false, "message" => "Todo id not passed"]));
    }
    if (!isset($data->newContent)) {
        exit(json_encode(["status" => false, "message" => "new Content Can't Be Empty"]));
    }
    if (strlen(trim($data->newContent)) < 5) {
        exit(json_encode(["status" => false, "message" => "new Content Is Too Short"]));
    }
    $todoUID = htmlspecialchars($data->todoUID);
    $newContent = htmlspecialchars($data->newContent);
    exit(json_encode($todo->ModifyTodo($res["userID"], $todoUID, $newContent)));
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    if (!isset($data->todoUID)) {
        exit(json_encode(["status" => false, "message" => "Todo id not passed"]));
    }
    $todoUID = htmlspecialchars(trim($data->todoUID));
    exit(json_encode($todo->DeleteOneTodo($res["userID"], $todoUID)));
} elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    exit(json_encode($todo->ClearUserTodo($res["userID"])));
} else {
    exit(json_encode(["status" => false, "message" => "Method Not Allowed"]));
}
