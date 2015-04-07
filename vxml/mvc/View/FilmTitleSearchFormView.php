<?php
class FilmTitleSearchFormView extends View
{

    public function prepare($data)
    {
        $data['title'] = "Introduzca el titulo de la pelicula a buscar";
        $data['field'] = "titulo";
        $this->render("filmSearchForm.phtml", $data);
    }
}