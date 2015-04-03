<?php
Abstract Class Controller {
    const BASE_URL = "/index.php?";
    private $navigation;

    function __construct()
    {
        $this->navigation = new NavigationMap();
    }

    abstract public function index($data);

    public function render($template, $data) {
       require_once __DIR__ . "/../template/" . $template;
       ob_start();
       include($template);//How to pass $param to it? It needs that $row to render blog entry!
       $ret = ob_get_contents();
       ob_end_clean();
       return $ret;
    }

    public function getLink($controllerName, $action, $params) {
        $this->assertLinkIsValid($controllerName, $action, $params);

        $url = self::BASE_URL . $this->getUrlParam(NavigationMap::CONTROLLER_PARAM, $controllerName)
            . '&' . $this->getUrlParam(NavigationMap::ACTION_PARAM, $action) . $this->getUrlGetParams($params);

        return $url;
    }

    private function assertLinkIsValid($controllerName, $action, $params) {
        foreach ($params as $paramName => $paramValue) {
            if (!$this->navigation->isValidGetParam($controllerName, $action, $paramName)) {
                throw new DomainException("$controllerName with $action and $paramName not configured in NavigationMap yet");
            }
        }


    }

    private function getUrlParam($paramName, $paramValue)
    {
        return "$paramName=" . urlencode($paramValue);
    }

    private function getUrlGetParams($params)
    {
        $url = '';
        foreach($params as $paramName => $paramValue) {
            $url .= '&' . $this->getUrlParam($paramName, $paramValue);
        }
        return $url;
    }

}