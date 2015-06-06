<?php
class FilmMainMenuView extends MenuView
{
	/**
	 * @param MenuViewData $viewData
	 */
	public function render($viewData)
	{
		$viewData->setPrompt(" Bienvenido al sistema de informacion de peliculas por telefono."
			. " Para buscar una película por título pulse 1 o diga búsqueda por título."
			. " Para buscar una película por actor pulse 2 o diga búsqueda por actor."
			. " Para buscar una pelicula por director pulse 3 o diga búsqueda por director. "
			. " Para oir la cartelera pulse 4 o diga ver cartelera o diga cartelera.");
		parent::render($viewData);
	}




}