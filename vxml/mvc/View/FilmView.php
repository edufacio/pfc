<?php
class FilmView extends View
{
    public function prepare($data)
    {
        $this->render("filmView.phtml", $data);
    }
}