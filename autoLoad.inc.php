<?php
spl_autoload_register("autoInclude");
function autoInclude($class)
{
    if (file_exists("Model/" . $class . 'Model.php')) {
        include "Model/" . $class . 'Model.php';
    } elseif ("Controller/" . $class . '.php') {
        include "Controller/" . $class . '.php';
    }
}
