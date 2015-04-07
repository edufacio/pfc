<?php
class FilmDirectorSearchFormView extends View
{

    public function prepare($data)
    {
        $data['title'] = "Introduzca el nombre del director a buscar";
        $data['field'] = "director";
        $this->render("filmSearchForm.phtml", $data);
    }
}