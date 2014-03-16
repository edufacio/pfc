<?php

//Abrimos el fichero en modo lectura
$ar = fopen("pelicula.txt","r") or
    die("No se pudo abrir el archivo");

    
$fp = fopen("lectura.txt", "w") or
    die("No se pudo abrir el archivo");

//Recogemos la informacion de la pelicula que nos interese: Titulo, Director, Genero, Sinopsis, Nota)
$text = file_get_contents("pelicula.txt");
    		
$titulo = find("/T&Iacute;TULO ORIGINAL/", $text);
$director = find("/DIRECTOR/", $text);
$genero= find("/G&Eacute;NERO/", $text);
$sinopsis = find("/SINOPSIS</", $text);
$nota = find("/font-size:22px/", $text);
 
 
private function find($pattern, $text) {
	preg_match_all($pattern, $text, $matches);
	return strip_tags($matches[0][0]);
} 
  
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

