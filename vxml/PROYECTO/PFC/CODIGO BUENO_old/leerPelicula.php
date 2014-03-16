<?php
function conectarse()
{
	//Nos conectamos a la base de datos
	/*$mysql_host = "sql109.arredemo.org";
	$mysql_database = "adm_7308952_cine";
	$mysql_user = "adm_7308952";
	$mysql_password = "jose26284";*/
	$mysql_host = "db56.1and1.es";
	$mysql_database = "db362330055";
	$mysql_user = "dbo362330055";
	$mysql_password = "jose26284";
	
	if (!($link=mysql_connect($mysql_host,$mysql_user,$mysql_password)))
	{
		echo "Error conectando a la base de datos.";
		exit();
	}
	if (!mysql_select_db($mysql_database,$link))
	{
		echo "Error seleccionando la base de datos.";
		exit();
	}
	
	return $link;	
	//mysql_select_db($mysql_database, $link);
}

$link=Conectarse(); //Nos conectamos a la base de datos
mysql_select_db($mysql_database, $link);

//Consulta para sacar el ID y el nombre de la pelicula y poder buscar en filmaffinity
$consulta = mysql_query("SELECT * FROM pelicula WHERE nombre LIKE '%" . $_REQUEST["nombre"] . "%'");

//guardamos el ID y el nombre de la pelicula en una variable
while ($dato = mysql_fetch_array($consulta))
{	$id='ID: '.$dato['id']."\n";
	//$nombre='Nombre: '.$dato['nombre']."\n";
	//echo 'ID: '.$id; 
	//echo '<br>Nombre/pelicula: '.$nombre.'<br>';
}

//******* TENGO QUE QUITAR EL ESPACIO DEL NOMBRE RECIBIDO Y PONER UN +, PARA QUE CUMPLA EL FORMATO DE LA URL
/*$nombre =  $_REQUEST["nombre"];
for($i=0;$i<strlen($nombre);$i++){
	if ($nombre[$i] == ' ')
		$nombre2=$nombre2."+"; 
	else
		$nombre2=$nombre2.$nombre[i];
}*/	

//Capturamos el contenido de la pelicula que ha dicho el usuario
$ch = curl_init("http://www.filmaffinity.com/es/film$id.html");
$fp = fopen("pelicula.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);

fclose($fp);

//Abrimos el fichero en modo lectura
$ar=fopen("pelicula.txt","r") or
    die("No se pudo abrir el archivo");

//$i=0; // Variable para indicar el ID cuando insertamos en la base de datos
//Recogemos la informacion de la pelicula que nos interese: Titulo, Director, Género, Sinopsis, Nota)
while (!feof($ar))
  {    
	$lineaSalto=fgets($ar); //Lee una linea del fichero
    		
	if (eregi("ORIGINAL", $lineaSalto)){  //Buscamos la clave (ORIGINAL) dentro de la linea --> TITULO
		$lineaSalto=fgets($ar); //Leemos otra linea del fichero porque el TITULO esta en la siguiente linea de la clave
		$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
    }
	else if (eregi("director&", $lineaSalto)){  //Buscamos la clave (director&) dentro de la linea --> DIRECTOR
		$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
    }
	else if (eregi("genre=", $lineaSalto)){  //Buscamos la clave (genre=) dentro de la linea --> GENERO
		$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
	}
	else if (eregi("SINOPSIS</b>", $lineaSalto)){  //Buscamos la clave (SINOPSIS</b>) dentro de la linea --> SINOPSIS
		$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
	}
	else if (eregi("font-size:22px", $lineaSalto)){  //Buscamos la clave (font-size:22px) dentro de la linea --> NOTA
		$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena
    }
		
	//Controlo el apostrofe ' de las palabras en ingles, para que se pueda insertar en la bbdd
	/*$nombre='';
	for($j=0;$j<strlen($titulo);$j++){
		if ($titulo[$j] == '\'')
			$nombre=$nombre."\'"; 
		else
			$nombre=$nombre.$titulo[$j];
	}*/
	$array[]= $titulo; //Guardamos en un array las peliculas
	//insertarDatos($numero, $nombre);
	//echo $nombre;
	//Guardamos en un array las peliculas
	/*if ($i!=0)
		$array[]= $nombre;
	$i=$i+1;*/
  }
  
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>


<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xmlns:voxeo="http://community.voxeo.com/xmlns/vxml" xml:lang="es-MX"> 

<form id="pelicula">
	<field name="nombre">
        <prompt>
			La informacion de la pelicula <?php echo $id; ?> es: Titulo Original <?php echo $array[0]; ?>, 
			director <?php echo $array[1]; ?>, genero <?php echo $array[2]; ?> y la nota que tiene esta pelicula es <?php echo $array[3]; ?>
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
			<prompt>Diga la opcion que desee: volver para volver a la pagina de las pelicualas, repetir para volve a oir la informacion de la
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

