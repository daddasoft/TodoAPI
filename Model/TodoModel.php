<?php
class Todo extends DB
{
    public static function All($userID)
    {
        $res = DB::Select("SELECT todoUID,Content,CreatedAt From todos Where CreatedByID =:userID  order by CreatedAt DESC", [":userID" => $userID]);
        return $res;
    }
    public static function save($userID, $Content)
    {
        $res = DB::Insert("INSERT INTO `todos`(`todoUID`, `CreatedByID`, `Content`, `CreatedAt`)
        VALUES (REPLACE(UUID(),'-',''),:userID,:Content,NOW())",
            [":userID" => $userID, ":Content" => $Content]);
        return $res;
    }
    public static function Update($userID, $todoUID, $newContent)
    {
        $res = DB::Modify("UPDATE todos SET Content = :newContent
                           WHERE todoUID = :todoUID AND CreatedByID = :userID",
            [":newContent" => $newContent, ":userID" => $userID, ":todoUID" => $todoUID]);
        return $res;
    }
    public static function Remove($userID, $todoUID)
    {
        $res = DB::Delete("DELETE from todos Where CreatedByID=:userID AND todoUID=:todoUID",
            [":userID" => $userID, ":todoUID" => $todoUID]);
        return $res;
    }
    public static function Clear($userID)
    {
        $res = DB::Delete("DELETE from todos Where CreatedByID=:userID",
            [":userID" => $userID]);
        return $res;
    }
    public static function ShowIndex()
    {
        $res = DB::SelectWithoutParams("SELECT T.Content,T.CreatedAt,U.Username,U.CreatedAt as MemberSince FROM todos T join users U On U.UserID = T.CreatedByID order by T.CreatedByID");
                return $res;
    }
}
