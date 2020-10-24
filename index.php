<?php
$url = $_GET["url"] == "index.php" ? "/" : $_GET["url"];
include './Routes/Route.php';
include_once './autoLoad.inc.php';
include './Controller/headers.php';

Route::Set($url, '/', function () {
    include './api/index.php';
});

Route::Set($url, 'todo', function () {
    include './api/todo.php';
});
Route::Set($url, 'login', function () {
    include './api/login.php';
});
Route::Set($url, 'singup', function () {
    include './api/register.php';
});
Route::Set($url, 'resetPassword', function () {
    include './api/resetPassword.php';
});
Route::Set($url, 'changePassword', function () {
    include './api/changepassword.php';
});
Route::Set($url, 'autologin', function () {
    include './api/authLogin.php';
});
if (!in_array($url, Route::$RoutesAvailable)) {
    $url = "404";
}
Route::Set($url, '404', function () {
    include './api/404.php';
    http_response_code(404);
});
