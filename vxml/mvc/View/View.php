<?php
abstract class View {
    abstract public function prepare($data);
    static public function createView(){
        return new static();
    }

    public static function getViewName() {
        return __CLASS__;
    }
    protected function render($template, $data) {
        require_once __DIR__ . "/../template/" . $template;
        ob_start();
        include($template);
        $ret = ob_get_contents();
        ob_end_clean();
        return $ret;
    }
}