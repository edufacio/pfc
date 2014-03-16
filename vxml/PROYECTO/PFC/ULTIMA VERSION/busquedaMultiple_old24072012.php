<?php

//Abrimos el fichero en modo lectura
$ar = fopen("pelicula.txt","r") or
    die("No se pudo abrir el archivo");

    
$fp = fopen("lectura.txt", "w") or
    die("No se pudo abrir el archivo");

//Recogemos las peliculas que se han encontrado

while (!feof($ar))
  {    
	$lineaSalto = fgets($ar); //Lee una linea del fichero
    		
	
	//if (preg_match("/<b><a href=\"/es/film[0-9]+.html\">/", $lineaSalto))		
			
	if (preg_match("/<b><a href=/", $lineaSalto)){
		$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
		fputs($fp,"\n");
		fputs($fp,$lineaSalto);		
		fputs($fp,$titulo);
    	}
  }
  
fputs($fp,"\n");
fputs($fp,"Fuera del bucle");	

fclose($fp);


echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
?>

<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml"  xml:lang="es-es">

<?php
header('Cache-Control: no-cache');
?> 

<	
<form id="MainMenu">
	<field name="cine">
	<prompt>
		Perfecto, estas en busqueda multiple.
	</prompt>
		
	<noinput>
		Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
		<reprompt/>
	</noinput>
	
	<nomatch>
		Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
		<reprompt/>
	</nomatch>
	  
	</field>
	
</form>
</vxml>