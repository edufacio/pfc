<?php
class MenuFilmView extends View
{
    public function prepare($data)
    {
        $this->render("MenuFilm.phtml", $data);
    }
}