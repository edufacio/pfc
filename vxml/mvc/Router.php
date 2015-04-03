<?php
require_once __DIR__ . "/controller/Controller.php";
require_once __DIR__ . "/NavigationMap.php";

Class Router
{
    public function request()
    {

        $navigationMap = new NavigationMap();
        $controllerName = $navigationMap->getControllerName();
        $action = $navigationMap->getAction();
        $data = $navigationMap->getData($controllerName, $action);
        $controllerClass = $controllerName . "Controller";
        require_once __DIR__ . "/controller/" . $controllerClass . ".php";
        $controller = new $controllerClass();
        $controller->$action($data);


        foreach (array('server' => $_SERVER, 'get' => $_GET, 'post' => $_POST, 'req' => $_REQUEST) as $i => $info) {
            echo "<ul> $i";

            foreach ($info as $k => $v) {
                echo "<li> $k => $v";
            }
            echo "<ul>";

        }
    }
}