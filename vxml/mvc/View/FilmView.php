<?php
class FilmView extends View
{
    public function render($data)
    {
        $this->renderOnTemplate($data, "filmView.phtml");
    }
}