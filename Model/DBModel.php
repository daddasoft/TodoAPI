<?php
class DB
{
    protected static $username = "root";
    protected static $password = 'dadda';
    protected static $dsn = 'mysql:host=localhost;dbname=todoapi';
    protected static function connect()
    {
        $conn = new PDO(self::$dsn, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    }
    protected static function Select($sql, $prepare)
    {
        $data = self::connect()->prepare($sql);
        $data->execute($prepare);
        $data = $data->fetchAll();
        return $data;
    }
    protected static function SelectSingle($sql, $prepare)
    {
        $data = self::connect()->prepare($sql);
        $data->execute($prepare);
        $data = $data->fetch();
        return $data;
    }
    protected static function Insert($sql, $prepare)
    {
        $res = self::connect()->prepare($sql);
        $res->execute($prepare);
        return $res;
    }
    protected static function Modify($sql, $prepare)
    {
        $res = self::connect()->prepare($sql);
        $res->execute($prepare);
        return $res;
    }
    protected static function Delete($sql, $prepare)
    {
        $res = self::connect()->prepare($sql);
        $res->execute($prepare);
        return $res;
    }
}
