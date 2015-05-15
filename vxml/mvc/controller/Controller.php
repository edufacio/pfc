<?php
require_once dirname(__FILE__) . '/Link.php';
require_once dirname(__FILE__) . "/../view/View.php";
Abstract Class Controller {
    const BASE_URL = "index.php?";
    private $navigation;

    function __construct()
    {
        $this->navigation = new NavigationMap();
    }

    abstract public function index($data);

    public function getLink($controllerName, $action, $params = array()) {
        $this->assertLinkIsValid($controllerName, $action, $params);

        $url = self::BASE_URL . $this->getUrlParam(NavigationMap::CONTROLLER_PARAM, $controllerName)
            . '&' . $this->getUrlParam(NavigationMap::ACTION_PARAM, $action) . $this->getUrlGetParams($params);

        return new Link($url);
    }

    /**
     * @param $view
     * @return View
     */
    protected function instantiateView($view) {
        require_once dirname(__FILE__) . "/../view/" . $view . ".php";
        return new $view();
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