<?php
Class Router
{
    public function request()
    {

        foreach (array('server' => $_SERVER, 'get' => $_GET, 'post' => $_POST, 'req' => $_REQUEST) as $i => $info) {
            echo "<ul> $i";

            foreach ($info as $k => $v) {
                echo "<li> $k => $v";
            }
            echo "<ul>";

        }
    }
}