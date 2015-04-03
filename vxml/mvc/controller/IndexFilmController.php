<?php
require_once __DIR__ . '/../../api/FilmAffinityApi.php';
Class IndexFilmController extends Controller {
    const CONTROLLER_NAME = 'IndexFilm';
    const TITLE_PARAM = 'title';
    public function index($data)
    {
        var_dump('lolololo');
        var_dump($data);
    }

    public function searchTitle($data)
    {
        var_dump('lolaolo');
        var_dump($data);
        $data['puto'] = FilmAffinityApi::getInstance()->searchTitle($data[self::TITLE_PARAM]);
        $data['link'] = $this->getLink(self::CONTROLLER_NAME, 'searchTitle', array(self::TITLE_PARAM =>"muertos de risa"));
        $this->render('test.phtml', $data);
    }

}