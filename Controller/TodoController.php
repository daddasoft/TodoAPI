<?php
class TodoController
{

    public function getTodo($userID)
    {
        $res = Todo::All($userID);
        if ($res) {
            return ["status" => true, "data" => $res];
        }
        return ["status" => false, "message" => "No Todo To Show"];
    }
    public function AddTodo($userID, $content)
    {
        $content = htmlspecialchars(trim($content));
        $res = Todo::save($userID, $content);
        if (strlen(trim($content)) < 5) {
            return ["status" => false, "message" => "The Content Is To Short"];
        }
        if ($res->rowCount() > 0) {
            return ["status" => true, "message" => "Todo Has Been Added"];
        }
        return ["status" => false, "message" => "Todo Can't Be Added"];
    }
    public function ModifyTodo($userID, $todoUID, $newContent)
    {
        $todoUID = htmlspecialchars(trim($todoUID));
        $newContent = htmlspecialchars(trim($newContent));
        $res = Todo::Update($userID, $todoUID, $newContent);
        if ($res->rowCount() > 0) {
            return ["status" => true, "message" => "Todo Has Been Modified"];
        }
        return ["status" => false, "message" => "No Action Affected"];
    }

    public function DeleteOneTodo($userID, $todoUID)
    {
        $todoUID = htmlspecialchars(trim($todoUID));
        $res = Todo::Remove($userID, $todoUID);
        if ($res->rowCount() > 0) {
            return ["status" => true, "message" => "Todo Has Been Deleted"];
        }
        return ["status" => false, "message" => "No Action Affected"];
    }
    public function ClearUserTodo($userID)
    {
        $res = Todo::Clear($userID);
        if ($res->rowCount() > 0) {
            return ["status" => true, "message" => "Todo Has Been Cleared"];
        }
        return ["status" => false, "message" => "No Action Affected"];
    }
}
