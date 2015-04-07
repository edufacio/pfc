<?php
class FilmsResultView extends View
{
    public function prepare($data)
    {
        $this->render("filmsResult.phtml", $data);
    }
}