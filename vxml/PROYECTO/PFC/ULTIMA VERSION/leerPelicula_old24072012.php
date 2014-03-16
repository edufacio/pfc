<?php

//header('Content-Type: text/html; charset=ISO-8859-1');

//Capturamos el contenido de la pagina web y lo guardamos en el fichero "pelicula.txt"

//$NomPelicula = $_REQUEST["nombre"];
//$ch = curl_init("http://www.filmaffinity.com/es/search.php?stext=$NomPelicula&stype=all");

//$ch = curl_init("http://www.filmaffinity.com/es/film518309.html");

//$fp = fopen("pelicula_curl.txt", "w");

//curl_setopt($ch, CURLOPT_FILE, $fp);
//curl_setopt($ch, CURLOPT_HEADER, 0);

//curl_exec($ch);
//curl_close($ch);

//fclose($fp);

//FORMA GUENA
//$NomPelicula = 'infiltrados';
//$texto = utf8_encode(file_get_contents("http://www.filmaffinity.com/es/search.php?stext=$NomPelicula&stype=all"));

//$texto = utf8_encode(file_get_contents("http://www.filmaffinity.com/es/film333672.html"));

//file_put_contents('pelicula.txt', $texto);  

/*$url = fopen("http://www.filmaffinity.com/es/search.php?stext=$NomPelicula&stype=all", "r");

$jp = fopen("lectura1.txt", "w") or
    die("No se pudo abrir el archivo");


if($url)
{
	$texto="";
	while(!feof($url)){
		$texto .= fgets($url, 1024);

	}
}
$cod1 = mb_detect_encoding($texto);
fputs($jp,$cod1);
fputs($jp,"\n");

$text = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $texto);
		
$cod = mb_detect_encoding($text);

fputs($jp,$cod);
fputs($jp,"\n");

fclose($jp);

$fp = fopen("pelicula.txt", "w");//Abrimos el fichero en modo escritura
fputs($fp,$text);
fclose($fp);
*/

//Abrimos el fichero en modo lectura
$ar = fopen("pelicula.txt","r") or
    die("No se pudo abrir el archivo");

    
$fp = fopen("lectura.txt", "w") or
    die("No se pudo abrir el archivo");
 


//Recogemos la informacion de la pelicula que nos interese: Titulo, Director, Genero, Sinopsis, Nota)

$fin = 0;
while ($fin == 0)
  {    
	$lineaSalto = fgets($ar); //Lee una linea del fichero
    		
	if (preg_match("/T&Iacute;TULO ORIGINAL/", $lineaSalto)){  //Buscamos la clave (<th>T&Iacute;TULO ORIGINAL</th>) dentro de la linea --> TITULO
		$lineaSalto = fgets($ar); //Leemos otra linea del fichero porque el TITULO esta en la siguiente linea de la clave
		$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
		fputs($fp,"\n");
		fputs($fp,$lineaSalto);		
		fputs($fp,$titulo);
    	}
	else if (preg_match("/DIRECTOR/", $lineaSalto)){  //Buscamos la clave (<th>DIRECTOR</th>) dentro de la linea --> DIRECTOR
		$lineaSalto = fgets($ar);
		$director = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
		fputs($fp,"\n");
		fputs($fp,$lineaSalto);
		fputs($fp,$director);
    	}
	else if (preg_match("/G&Eacute;NERO/", $lineaSalto)){  //Buscamos la clave (<th>G&Eacute;NERO</th>) dentro de la linea --> GENERO
		$lineaSalto = fgets($ar);
		$lineaSalto = fgets($ar);		
		$genero = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
		//$genero = "Thriller.      Drama.      Accion | Mafia. Remake. Crimen. Policiaco";
		fputs($fp,"\n");
		fputs($fp,$lineaSalto);		
		fputs($fp,$genero);
	}
	else if (preg_match("/SINOPSIS</", $lineaSalto)){  //Buscamos la clave (<th>SINOPSIS</th>) dentro de la linea --> SINOPSIS
		$lineaSalto = fgets($ar);
		$sinopsis = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
		
		$sinopsis = str_replace("(FILMAFFINITY)", "", $sinopsis); //Eliminamos (FILMAFFINITY) del final de la cadena para que no lo lea al usuario
		fputs($fp,"\n");
		fputs($fp,$lineaSalto);		
		fputs($fp,$sinopsis);
	}
	else if (preg_match("/font-size:22px/", $lineaSalto)){  //Buscamos la clave (font-size:22px) dentro de la linea --> NOTA
		$nota = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
		fputs($fp,"\n");
		fputs($fp,$lineaSalto);		
		fputs($fp,$nota);
		$fin = 1;
    	}
   
  }
  
fputs($fp,"\n");
fputs($fp,"Fuera del bucle");	

fclose($fp);
  
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
?>

<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xml:lang="es-es">

<form id="InfoPelicula">
	<field name="info">
        <prompt>
			La informacion de la pelicula es la siguiente: Titulo Original <?php echo $titulo; ?>,
			el director es: <?php echo $director; ?>, el genero de la pelicula es: <?php echo $genero; ?>,
			La Sinopsis de la pelicula es: <?php echo $sinopsis; ?>
			La nota que tiene esta pelicula es: <?php echo $nota; ?>       
        
			Si desea volver a oir la informacion de la pelicula, diga repetir. Si desea volver al menu principal, diga menu.
			Si desea informacion de otra pelicula, diga pelicula.
		</prompt>
		
		<grammar type="text/gsl">
			[repetir menu pelicula]
		</grammar>
		
		<noinput>
           Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
           <reprompt/>
        </noinput>
    </field>
	
	<filled namelist="info">
		<if cond="info == 'pelicula'">
			<submit next="pelicula.php" method="get" namelist="info"/>
		<elseif cond="info == 'repetir'"/>
			<submit next="leerPelicula.php" method="get" namelist="info"/>
		<elseif cond="info == 'menu'"/>
			<submit next="menu.php" method="get" namelist="info"/>
		</if> 
    </filled>
</form>	
</vxml>

