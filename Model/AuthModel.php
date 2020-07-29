<?php
class Auth extends DB
{

    public static function GenerateToken($length)
    {
        $crypto = true;
        return bin2hex(openssl_random_pseudo_bytes($length, $crypto));
    }

    public static function InsetToken($userID, $token)
    {
        return DB::Insert("INSERT INTO `token`(`UserID`, `Usertoken`, `ExpiredOn`)
        VALUES (:userID,:token,ADDDATE(CURRENT_TIMESTAMP(),INTERVAL 1 DAY))", [":token" => $token, ":userID" => $userID])->rowCount();
    }

    public static function DeleteTokens($userID)
    {
        return DB::Delete("DELETE FROM token Where UserID = :userID", [":userID" => $userID]);
    }
    public static function GetToken($token)
    {
        return DB::SelectSingle("SELECT ExpiredOn ,UserID FROM token WHERE Usertoken = :token", [":token" => $token]);
    }

}
