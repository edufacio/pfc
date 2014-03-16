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

function borrarDatos()
{
	$link=conectarse();
	//echo "Conexion satisfactoria a la base de datos";
	
	// Borramos los datos en la base de datos
	mysql_query("truncate table cartelera",$link);
	echo "Datos borrados".'<br>';
	
	mysql_close($link); //cierra la conexion
}

function insertarDatos($titulo)
{
	$link=conectarse();
	echo "Conexion satisfactoria a la base de datos";
	
	// Insertamos los datos en la base de datos
	mysql_query("INSERT INTO cartelera (nombre) VALUES ('$titulo')",$link);
	//echo $i.' Dato insertado: '.$titulo.'<br>';
	
	mysql_close($link); //cierra la conexion
}

//Capturamos el contenido de la cartelera de la pagina web y lo guardamos en el fichero "cartelera.txt"

$ch = curl_init("http://www.filmaffinity.com/es/cat_new_th_es.html");
$fp = fopen("cartelera.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);

fclose($fp);

//Borramos los datos de la tabla cartelera
borrarDatos();

//Abrimos el fichero en modo lectura
$ar=fopen("cartelera.txt","r") or
    die("No se pudo abrir el archivo");

$i=0; // Variable para indicar el ID cuando insertamos en la base de datos
while (!feof($ar))
  {    
	$lineaSalto=fgets($ar); //Lee una linea del fichero
    $clave="class=\"ntext\""; // Clave que nos indica la linea que nos interesa

    //Buscamos la clave dentro de la linea y sacamos el titulo de la pelicula
    if (eregi($clave, $lineaSalto)){
		//Elimina todas las etiquetas HTML y PHP de una cadena
		$titulo = strip_tags($lineaSalto); 
		
		//Controlo el apostrofe ' de las palabras en ingles, para que se pueda insertar en la bbdd
		$nombre='';
		for($j=0;$j<strlen($titulo);$j++){
			if ($titulo[$j] == '\'')
				$nombre=$nombre."\'"; 
			else
				$nombre=$nombre.$titulo[$j];
		}	
		
		$i=$i+1;
		echo $i.': '.$nombre.'<br>';
		
		//Guardamos las peliculas de la cartelera en la base de datos
		insertarDatos($nombre);
    }
  }
?>


