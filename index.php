<?php

session_start();

mb_internal_encoding("UTF-8");
function autoloadFunction($class): void
{
    if (str_ends_with($class, 'Controller'))
        require("controllers/" . $class . ".php");
    elseif (str_ends_with($class, 'Service'))
        require("services/" . $class . ".php");
    elseif (str_ends_with($class, 'Enum'))
        require("enums/" . $class . ".php");
    else
        require("models/" . $class . ".php");
}

spl_autoload_register("autoloadFunction");

Db::connect("127.0.0.1", "root", "", "online_shop");
$router = new RouterController();
$router->process([$_SERVER['REQUEST_URI']]);
$router->renderView();