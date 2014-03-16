<?php

//Se obtiene la pel�cula que ha dicho el usuario
$NomPelicula = $_REQUEST["nombre"];
	
/* SE QUITAN LOS ESPACIOS DEL NOMBRE RECIBIDO Y SE PONE EL SIMBOLO +, PARA CUMPLIR EL FORMATO DE LA URL */
for($i=0; $i < strlen($NomPelicula); $i++){
	if ($NomPelicula[$i] == ' ')
		$pelicula = $pelicula."+";
	else
		$pelicula = $pelicula.$NomPelicula[$i];
}

/* PRUEBAA 
file_put_contents('Nombrepelicula.txt', $pelicula);  
*/

//FORMA GUENA
//$NomPelicula = 'infiltrados';
$texto = utf8_encode(file_get_contents("http://www.filmaffinity.com/es/search.php?stext=$pelicula&stype=all"));

//$texto = utf8_encode(file_get_contents("http://www.filmaffinity.com/es/film333672.html"));
//Se guarda en un fichero, el c�digo de la p�gina que se ha buscado
file_put_contents('pelicula.txt', $texto);  


/*Abrimos el fichero en modo lectura, para comprobar si en la busqueda de la pel�cula se ha obtenido la informaci�n de la pel�cula o si por
el contrario se han obtenido varias pel�culas con el mismo nombre*/
$ar = fopen("pelicula.txt","r") or
    die("No se pudo abrir el archivo");

//Se parsea el c�digo en busqueda de la CLAVE: Resultados por t�tulo
$fin = 0;

while (!feof($ar))
{    
	$lineaSalto = fgets($ar); //Lee una linea del fichero
	
	//Buscamos la clave (Resultados por t�tulo)
	if (preg_match("/Resultados por t/", $lineaSalto)){
		$fin = 1;
    	}   
}

/*Si se ha obtenido la informacion de la pelicula deseada, redireccionamos a leerPilucula.php*/
if ($fin == 0){

	header('Location: leerPelicula.php');

}
/*Si no, redireccionamos a busquedaMultiple.php para buscar la pelicula deseada por el usuario */
else {
 	
	header('Location: busquedaMultiple.php');
}

?>

