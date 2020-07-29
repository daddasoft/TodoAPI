<?php
class Route
{

    static $RoutesAvailable = [];

    public static function Set($url, $route, Closure $callback)
    {
        self::$RoutesAvailable[] = $route;

        if ($url == $route) {
            $callback->__invoke();
        }
    }
}
