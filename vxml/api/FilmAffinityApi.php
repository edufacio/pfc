<?
require_once __DIR__ .'/simple_html_dom.php';

//var_dump(FilmAffinityApi::getInstance()->getFilm("376816"));
//var_dump(FilmAffinityApi::getInstance()->getCartelera());
//var_dump(FilmAffinityApi::getInstance()->searchActor("santiago segura"));

class FilmAffinityApi
{
    const BASE_URL = "http://www.filmaffinity.com/";
    const ACTOR_QUERY = "es/search.php?stype=cast&stext=";
    const TITLE_QUERY = "es/search.php?stype=title&stext=";
    const DIRECTOR_QUERY = "es/search.php?stype=director&stext=";
    const CARTELERA_QUERY = "/es/cat_new_th_es.html";
    const FILM_QUERY = '/es/film%id%.html';
    private static $instance;

    public static function getInstance()
    {
       if (self::$instance == null) {
           self::$instance = new FilmAffinityApi();
       }
       return self::$instance;
    }

    /**
     * @param $directorName
     * @return array
     */
    public function getFilm($filmId)
    {
        $result = array();

        $pageDom = $this->request(str_replace('%id%', $filmId, self::FILM_QUERY));
        $keysContent = $pageDom->find('dl[class=movie-info] dt');
        $content = $pageDom->find('dl[class=movie-info] dd');

        foreach ($keysContent as $key => $value) {

            $result[$value->text()] = $content[$key]->text();
        }
        return $result;
    }
    /**
     * @param $directorName
     * @return array
     */
    public function searchDirector($directorName)
    {
        $result = array();
        $query = self::DIRECTOR_QUERY . $this->escapeQuery($directorName);
        $pageDom = $this->request($query);
        $films = $pageDom->find('div[class=mc-title] a');
        foreach ($films as $film) {

            $result[$this->getFilmId($film->href)] = $film->text();
        }
        return $result;
    }

    /**
     * @param $title
     * @return array
     */
    public function searchTitle($title)
    {
        $result = array();
        $query = self::TITLE_QUERY . $this->escapeQuery($title);
        $pageDom = $this->request($query);
        $films = $pageDom->find('div[class=mc-title] a');
        foreach ($films as $film) {

            $result[$this->getFilmId($film->href)] = $film->text();
        }
        return $result;
    }

    /**
     * @param $actorName
     * @return array
     */
    public function searchActor($actorName)
    {
        $result = array();
        $query = self::ACTOR_QUERY . $this->escapeQuery($actorName);
        $pageDom = $this->request($query);
        $films = $pageDom->find('div[class=mc-title] a');
        foreach ($films as $film) {

            $result[$this->getFilmId($film->href)] = $film->text();
        }
        return $result;
    }

    private function escapeQuery($query) {
        return urlencode($query);
    }

    /**
     * @return array
     */
    public function getCartelera()
    {
        $result = array();
        $pageDom = $this->request(self::CARTELERA_QUERY);
        $films = $pageDom->find('div[class=movie-card] h3 a');
        foreach ($films as $film) {
            $result[$this->getFilmId($film->href)] = $film->text();
        }
        return $result;
    }

    /**
     * @param $page
     * @return simple_html_dom
     */
    private function request($page)
    {
        $c = curl_init(self::BASE_URL . $page);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($c);
        $dom = New simple_html_dom();
        $dom->load($html);
        return $dom;
    }

    private function getFilmId($href)
    {
        preg_match('/\d+/', $href, $match);
        return $match[0];
    }
}





