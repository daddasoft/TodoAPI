<?php
class AuthController
{

    public function ValidateToken($token)
    {
        $token = htmlspecialchars($token);
        $res = Auth::GetToken($token);
        if ($res) {
            $now = gmdate("Y m d H:i:s");
            $then = date(str_replace('-', ' ', $res["ExpiredOn"]));
            if ($now < $then) {
                return ["status" => true, "data"=>$res];
            }
            return ["status" => false, "message" => "Token Is Expired Please Login"];
        }
        return ["status" => false, "message" => "Invalid User Token"];
    }
    public function GeneratedToken()
    {
        return Auth::GenerateToken(100);
    }
    public function PutToken($userID, $token)
    {
        return Auth::InsetToken($userID, $token);
    }
    public function DeleteToken($userID)
    {
        return Auth::DeleteTokens($userID);
    }

}
