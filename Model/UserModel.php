<?php
class User extends DB
{

    public static function Login($username)
    {
        return DB::SelectSingle("SELECT `UserID`,`Password` FROM `users` WHERE `Username` = :username
                    OR `Email`= :email",
            [":username" => $username, ":email" => $username]);

    }
    public static function Register($username, $email, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        return DB::Insert("INSERT INTO users ( `Username`, `Email`, `Password`, `CreatedAt`) Values
                               (:username,:email,:password,NOW())",
            [":username" => $username, ":email" => $email, ":password" => $password])->rowCount();

    }
    public static function CheckUsername($username)
    {
        return DB::SelectSingle("SELECT Username FROM users Where Username =:username", [":username" => $username]);
    }
    public static function CheckEmail($email)
    {
        return DB::SelectSingle("SELECT Email FROM users Where Email =:email", [":email" => $email]);

    }

    public static function GetPassword($userID)
    {
        return DB::SelectSingle("SELECT Password FROM users Where userID =:userID", [":userID" => $userID]);
    }
    public static function ChangePassword($userID, $newPassword)
    {
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return DB::Modify("UPDATE Users SET Password=:password WHERE userID =:userID", [":userID" => $userID, ":password" => $newPassword]);
    }

}
