<?php
class MenuFilmView extends View
{
    static public function createView()
    {
        return new MenuFilmView();
    }

    public function prepare($data)
    {
        $this->render("MenuFilm.phtml", $data);
    }
}