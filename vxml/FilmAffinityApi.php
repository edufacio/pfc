<?
require_once 'simple_html_dom.php';

var_dump(FilmAffinityApi::getInstance()->getFilm("/es/film249518.html"));
#var_dump(FilmAffinityApi::getInstance()->getCartelera());
#var_dump(FilmAffinityApi::getInstance()->searchActor("santiago segura"));

class FilmAffinityApi
{
    const BASE_URL = "http://www.filmaffinity.com/";
    const ACTOR_QUERY = "es/search.php?stype=cast&stext=";
    const DIRECTOR_QUERY = "es/search.php?stype=director&stext=";
    const CARTELERA_QUERY = "/es/cat_new_th_es.html";
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
    public function getFilm($film)
    {
        $result = array();
        $pageDom = $this->request($film);
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

            $result[$film->href] = $film->text();
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

            $result[$film->href] = $film->text();
        }
        return $result;
    }

    private function escapeQuery($query) {
        return preg_replace('/\s+/', '+', $query);
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
            $result[$film->href] = $film->text();
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
}





