<?php
class UserController
{

    public function LoginController($username, $password)
    {
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        $res = User::Login($username);
        if ($res) {
            if (password_verify($password, $res["Password"])) {
                return ["status" => true, "userID" => $res["UserID"]];
            }
            return ["status" => false, "message" => "The Password Is Incorrect"];

        }
        return ["status" => false, "message" => "User Can't Be Found"];

    }
    public function RegisterController($username, $email, $password, $confirmPassword)
    {

        if (empty($username)) {
            return ["status" => false, "message" => "Username Can't Be Empty"];
        } elseif (strlen(trim($username)) < 5) {
            return ["status" => false, "message" => "Username Should At Least Contains 5 Characters"];
        } else if (User::CheckUsername($username)) {
            return ["status" => false, "message" => "Username Is Already being Taken"];
        } elseif (empty($email)) {
            return ["status" => false, "message" => "Email Can't Be Empty"];
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["status" => false, "message" => "Email Not In a Valid Format"];
        } else if (User::CheckEmail($email)) {
            return ["status" => false, "message" => "Email Is Already being Taken"];
        } else if (empty($password)) {
            return ["status" => false, "message" => "Password Can't Be Empty"];
        } else if ($password != $confirmPassword) {
            return ["status" => false, "message" => "Passwords Not Matches"];
        } else {
            $username = html_entity_decode(trim($username));
            $email = html_entity_decode(trim($email));
            $password = html_entity_decode(trim($password));
            $confirmPassword = html_entity_decode(trim($confirmPassword));
            $res = User::Register($username, $email, $password);
            if ($res > 0) {
                return ["status" => true, "message" => "User Created Successfully"];
            }
            return ["status" => false, "message" => "Error While Creating The User"];
        }

    }
    public function GetPasswordCon($userID)
    {
        return User::GetPassword($userID);
    }
    public function UpdatePassword($userID, $currentPassword, $newPassword, $confirmNewPassword)
    {
        if (empty($currentPassword)) {
            return ["status" => false, "message" => "Current Password Cant Be Empty"];
        } elseif (empty($newPassword)) {
            return ["status" => false, "message" => "Passwords Not Match"];
        } elseif (strlen(trim($newPassword)) < 5) {
            return ["status" => false, "message" => "Passwords should At Least Contains 5 Character"];
        } elseif ($newPassword != $confirmNewPassword) {
            return ["status" => false, "message" => "Passwords Not Match"];
        } else {
            $pwd = User::GetPassword($userID);
            if (!password_verify($currentPassword, $pwd["Password"])) {
                return ["status" => false, "message" => "Current Password Not Correct"];
            } else {
                $update = User::ChangePassword($userID, $newPassword);
                if ($update->rowCount() > 0) {
                    return ["status" => true, "message" => "Password Has Been Changed"];
                }
                return ["status" => false, "message" => "Password Can't Be Changed"];
            }
        }
    }

}
