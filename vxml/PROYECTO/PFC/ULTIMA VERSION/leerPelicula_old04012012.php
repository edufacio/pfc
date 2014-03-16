<?php

//header('Content-Type: text/html; charset=ISO-8859-1');

//Capturamos el contenido de la pagina web y lo guardamos en el fichero "pelicula.txt"

$NomPelicula = $_REQUEST["nombre"];
//$ch = curl_init("http://www.filmaffinity.com/es/search.php?stext=$NomPelicula&stype=all");

//$ch = curl_init("http://www.filmaffinity.com/es/film518309.html");

//$fp = fopen("pelicula_curl.txt", "w");

//curl_setopt($ch, CURLOPT_FILE, $fp);
//curl_setopt($ch, CURLOPT_HEADER, 0);

//curl_exec($ch);
//curl_close($ch);

//fclose($fp);


$url = fopen("http://www.filmaffinity.com/es/search.php?stext=$NomPelicula&stype=all", "r");

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

//$texto = mb_convert_encoding($texto, "ISO-8859-1");
$text = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $texto);
		
$cod = mb_detect_encoding($text);

fputs($jp,$cod);
fputs($jp,"\n");

fclose($jp);

$fp = fopen("pelicula.txt", "w");//Abrimos el fichero en modo escritura
fputs($fp,$text);
fclose($fp);


//Abrimos el fichero en modo lectura
$ar = fopen("pelicula.txt","r") or
    die("No se pudo abrir el archivo");
    
$fp = fopen("lectura.txt", "w") or
    die("No se pudo abrir el archivo");

    $a = "http://www.filmaffinity.com/es/search.php?stext=$NomPelicula&stype=all";
    
    fputs($fp,$a);
    fputs($fp,"\n");

//Recogemos la informacion de la pelicula que nos interese: Titulo, Director, Genero, Sinopsis, Nota)

$fin = 0;
while ($fin == 0)
  {    
	$lineaSalto=fgets($ar); //Lee una linea del fichero
    		
	if (preg_match("/ORIGINAL/", $lineaSalto)){  //Buscamos la clave (ORIGINAL) dentro de la linea --> TITULO
		$lineaSalto=fgets($ar); //Leemos otra linea del fichero porque el TITULO esta en la siguiente linea de la clave
		$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
		fputs($fp,"\n");
		fputs($fp,$lineaSalto);		
		fputs($fp,$titulo);
    	}
	else if (preg_match("/director&/", $lineaSalto)){  //Buscamos la clave (director&) dentro de la linea --> DIRECTOR
		$director = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
		fputs($fp,"\n");
		fputs($fp,$lineaSalto);
		fputs($fp,$director);
    	}
	else if (preg_match("/G&Eacute/", $lineaSalto)){  //Buscamos la clave (genre=) dentro de la linea --> GENERO
		$lineaSalto=fgets($ar);
		$lineaSalto=fgets($ar);		
		$genero = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
		//$genero = "Thriller.      Drama.      Accion | Mafia. Remake. Crimen. Policiaco";
		fputs($fp,"\n");
		fputs($fp,$lineaSalto);		
		fputs($fp,$genero);
	}
	else if (preg_match("/SINOPSIS</", $lineaSalto)){  //Buscamos la clave (SINOPSIS</th>) dentro de la linea --> SINOPSIS
		$lineaSalto=fgets($ar);
		$sinopsis = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
		//$sinopsis = " El Departamento de Policia de Massachussets se enfrenta a la mayor banda de crimen organizado de la ciudad. La estrategia consiste en acabar desde dentro con el poderoso jefe de la mafia Frank Costello (Jack Nicholson). El encargado de infiltrarse en la banda es un joven novato, Billy Costigan (Leonardo DiCaprio). Mientras Billy intenta ganarse la confianza de Costello, otro joven policia, Colin Sullivan (Matt Damon), sube rapidamente de categoria y ocupa un puesto en la unidad de Investigaciones Especiales, grupo de elite cuya mision tambien es acabar con Costello. Lo que sus superiores ignoran es que Colin trabaja para el. (FILMAFFINITY)";
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

<form id="pelicula">
	<field name="nombre">
        <prompt>
			La informacion de la pelicula <?php echo $NomPelicula; ?> es: Titulo Original <?php echo $titulo; ?>, 
			director <?php echo $director; ?>, genero <?php echo $genero; ?>, sinopsis <?php echo $sinopsis; ?> y la nota que tiene esta pelicula es <?php echo $nota; ?>       
        </prompt>
		
		<grammar type="text/gsl">
			[ayuda volver repetir principal siguiente anterior]
		</grammar>
		<noinput>
           Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
           <reprompt/>
        </noinput>
    </field>
	<filled namelist="nombre">
		<if cond="nombre == 'ayuda'">			
			<prompt>Diga la opcion que desee: volver para volver a la pagina de las peliculas, repetir para volve a oir la informacion de la
			pelicula, principal para volver al menu principal, siguiente para oir la informacion de la siguiente pelicula y anterior para
			oir la informacion de la pelicula anterior.</prompt>
		<elseif cond="nombre == 'volver'"/>
			<submit next="pelicula.php" method="get" namelist="nombre"/>
		<elseif cond="nombre == 'repetir'"/>
			<submit next="leerPelicula.php" method="get" namelist="nombre"/>
		<elseif cond="nombre == 'pricipal'"/>
			<submit next="menu.php" method="get" namelist="nombre"/>
		<elseif cond="nombre == 'siguiente'"/>
			
		<elseif cond="nombre == 'anterior'"/>
			
		<else/>
		</if> 
    </filled>
</form>

</vxml>

