<?php
class FilmActorSearchFormView extends View
{

    public function prepare($data)
    {
        $data['title'] = "Introduzca el nombre del actor a buscar";
        $data['field'] = "actor";
        $this->render("filmSearchForm.phtml", $data);
    }
}