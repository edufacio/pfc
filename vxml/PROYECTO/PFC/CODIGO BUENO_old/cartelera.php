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
		//echo "Error conectando a la base de datos.";
		exit();
	}
	if (!mysql_select_db($mysql_database,$link))
	{
		//echo "Error seleccionando la base de datos.";
		exit();
	}
	
	return $link;	
	//mysql_select_db($mysql_database, $link);
}

function borrarDatos()
{
	$link=conectarse();
	//echo "Conexion satisfactoria a la base de datos";
	
	// Borramos los datos en la base de datos
	mysql_query("truncate table cartelera",$link);
	//echo "Datos borrados".'<br>';
	
	mysql_close($link); //cierra la conexion
}

function insertarDatos($titulo)
{
	$link=conectarse();
	//echo "Conexion satisfactoria a la base de datos";
	
	// Insertamos los datos en la base de datos
	mysql_query("INSERT INTO cartelera (nombre) VALUES ('$titulo')",$link);
	//echo $i.' Dato insertado: '.$titulo.'<br>';
	
	mysql_close($link); //cierra la conexion
}

//Capturamos el contenido de la pagina web y lo guardamos en el fichero "cartelera.txt"

//EL SERVIDOR GRATUITO ARREDEMO NO ACEPTA LA FUNCION CURL

$ch = curl_init("http://www.filmaffinity.com/es/cat_new_th_es.html");
$fp = fopen("cartelera.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);

fclose($fp);
/*

//OTRA FORMA DE CAPTURAR EL CONTENIDO DE LA PAGINA WEB

$url = fopen("http://www.filmaffinity.com/es/cat_new_th_es.html", "r");

if($url)
{
	echo "Entra";
	$texto="";
	while(!feof($url)){
		$texto .= fgets($url, 1024);
	}
}
$fp = fopen("cartelera.txt", "w");//Abrimos el fichero en modo escritura
fputs($fp,$texto);
fclose($fp);
*/

//Abrimos el fichero en modo lectura
$ar=fopen("cartelera.txt","r") or
    die("No se pudo abrir el archivo");

//$i=0; // Variable para indicar el ID cuando insertamos en la base de datos

borrarDatos(); //Borramos los datos que contiene la tabla cartelera para actualizarla
while (!feof($ar))
  {    
	$lineaSalto=fgets($ar); //Lee una linea del fichero
    $clave="class=\"ntext\""; // Clave que nos indica la linea que nos interesa
    
    if (eregi($clave, $lineaSalto)){  //Buscamos una clave dentro de la linea
		$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena	
		
		//Controlo el apostrofe ' de las palabras en ingles, para que se pueda insertar en la bbdd
		$nombre='';
		for($j=0;$j<strlen($titulo);$j++){
			if ($titulo[$j] == '\'')
				$nombre=$nombre."\'"; 
			else
				$nombre=$nombre.$titulo[$j];
		}
		$array[]= $nombre; //Guardamos en un array las peliculas
		
		/*Si hago lo de guardar todas las peliculas no hace falta guardar estas peliculas en la tabla
		cartelera xq ya tendremos todas las peliculas en la tabla peliculas*/
		insertarDatos($nombre); //Guardamos las peliculas de la cartelera en la base de datos
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
				/*comprobar que funciona*/
				/*echo '[';
				for($i=0;$i<count($array);$i++)
					echo '('.$array[$i].') ';
				echo ']';*/
			?>
			[Thor (Agua para elefantes) (The Fast & Furious 5) (A todo gas 5) (No tengas miedo) (En un mundo mejor) (Torrente 4: Lethal Crisis) 
			(Torrente 4) (Cisne negro) (The Symmetry) (The Symmetry of Love) (El sicario de Dios) (El �ltimo exorcismo)]
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

