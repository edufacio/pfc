<?php
Class IndexFilmController extends Controller {
    const CONTROLLER_NAME = 'IndexFilm';
    const QUERY_PARAM = 'query';
    const FILM_ID = 'filmId';
    public function index($data)
    {
        $data['searchTitleLink'] = $this->getLink(self::CONTROLLER_NAME, "searchTitle");
        $data["searchActorLink"] = $this->getLink(self::CONTROLLER_NAME, "searchActor");
        $data["searchDirectorLink"] = $this->getLink(self::CONTROLLER_NAME, "searchDirector");
        $data["getCarteleraLink"] = $this->getLink(self::CONTROLLER_NAME, "getCartelera");
        $this->instantiateView('MenuFilmView')->prepare($data);
    }

    public function searchTitle($data)
    {
        $data['formLink'] = $this->getLink(self::CONTROLLER_NAME, "searchTitleForm");
        $this->instantiateView('FilmTitleSearchFormView')->prepare($data);
    }

    public function searchTitleForm($data)
    {
        $results = FilmAffinityApi::getInstance()->searchTitle($data[self::QUERY_PARAM]);
        $data["films"] = $this->getFilmsLinks($results);
        $this->instantiateView('FilmsResultView')->prepare($data);
    }

    public function getCarteleraLink($data)
    {
        $results = FilmAffinityApi::getInstance()->getCartelera(1,1);
        $data["films"] = $this->getFilmsLinks($results);
        $this->instantiateView('FilmsResultView')->prepare($data);
    }

    public function searchActor($data)
    {
        $data['formLink'] = $this->getLink(self::CONTROLLER_NAME, "searchActorForm");
        $this->instantiateView('FilmActorSearchFormView')->prepare($data);
    }

    public function searchActorForm($data)
    {
        $results = FilmAffinityApi::getInstance()->searchActor($data[self::QUERY_PARAM]);
        $data["films"] = $this->getFilmsLinks($results);
        $this->instantiateView('FilmsResultView')->prepare($data);
    }

    public function searchDirector($data)
    {
        $data['formLink'] = $this->getLink(self::CONTROLLER_NAME, "searchDirectorForm");
        $this->instantiateView('FilmDirectorSearchFormView')->prepare($data);
    }

    public function searchDirectorForm($data)
    {
        $results = FilmAffinityApi::getInstance()->searchDirector($data[self::QUERY_PARAM]);
        $data["films"] = $this->getFilmsLinks($results);
        $this->instantiateView('FilmsResultView')->prepare($data);
    }

    private function getFilmsLinks($filmsData)
    {
        $links = array();
        foreach($filmsData as $filmId => $filmTitle) {
            $link = $this->getLink(self::CONTROLLER_NAME, 'getFilm', array(self::FILM_ID => $filmId));
            $link->setText($filmTitle);
            $links[] = $link;
        }
        return $links;
    }

    public function getFilm($data)
    {
        $data['filmInfo'] = FilmAffinityApi::getInstance()->getFilm($data[self::FILM_ID]);
        $this->instantiateView('FilmView')->prepare($data);
    }

}