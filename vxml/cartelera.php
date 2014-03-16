<?php
//Capturamos el contenido de la pagina web y lo guardamos en el fichero "cartelera.txt"

$ch = curl_init("http://www.filmaffinity.com/es/cat_new_th_es.html");
$fp = fopen("cartelera.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);

fclose($fp);

//Abrimos el fichero en modo lectura
$ar=fopen("cartelera.txt","r") or
    die("No se pudo abrir el archivo");

while (!feof($ar))
  {    
	$lineaSalto=fgets($ar); //Lee una linea del fichero
    $clave="class=\"ntext\""; // Clave que nos indica la linea que nos interesa
    
    if (eregi($clave, $lineaSalto)){  //Buscamos una clave dentro de la linea
		$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena	
		$array[]= $titulo; //Guardamos en un array las peliculas
    }
  }

fclose($ar); 

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>


<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xmlns:voxeo="http://community.voxeo.com/xmlns/vxml" xml:lang="es-MX"> 

<form id="cartelera">
	<field name="nombre">
        <prompt>
			Estas son las peliculas que hay en cartelera, si quiere informacion de alguna de ella diga el nombre completo
			<?php
				for($i=0;$i<count($array);$i++)
					echo $array[$i];
			?>
        </prompt>
		
		<grammar type="text/gsl">
			<?php
				echo '[';
				for($i=0;$i<count($array);$i++)
					echo $array[$i].' ';
				echo ']';
			?>
		</grammar>
		
        <filled>
            <submit next="leerPelicula.php" method="get" namelist="nombre"/>
        </filled>
        <noinput>
           Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
           <reprompt/>
        </noinput>
    </field>
</form>

</vxml>

