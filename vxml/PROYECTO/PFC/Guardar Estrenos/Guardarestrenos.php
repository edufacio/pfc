<html>
<head>
	<title>Estrenos de cine</title>
</head>
<body>
<?php

function conectarse()
{
//Nos conectamos a la base de datos
	$mysql_host = "sql109.arredemo.org";
	$mysql_database = "adm_7308952_cine";
	$mysql_user = "adm_7308952";
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
	echo "Conexion satisfactoria a la base de datos ";
	
	// Insertamos los datos en la base de datos
	mysql_query("truncate table estrenos",$link);
	echo "Datos borrados".'<br>';
	
	mysql_close($link); //cierra la conexion
}

function insertarDatos($id, $nombre, $fecha)
{
	$link=conectarse();
	echo "Conexion satisfactoria a la base de datos ";
	
	// Insertamos los datos en la base de datos
	mysql_query("INSERT INTO estrenos (id,nombre, fecha_estreno) VALUES ('$id','$nombre', '$fecha')",$link);
	echo "Dato insertado".'<br>';
	
	mysql_close($link); //cierra la conexion
}


//Capturamos el contenido de la pagina web y lo guardamos en el fichero "estrenos.txt"

$ch = curl_init("http://www.filmaffinity.com/es/rdcat.php?id=upc_th_es");
$fp = fopen("estrenos.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);

fclose($fp);

//Borramos los datos de la tabla estrenos
borrarDatos();

//Abrimos el fichero en modo lectura
$ar=fopen("estrenos.txt","r") or
    die("No se pudo abrir el archivo");

$i=0; // Variable para indicar el ID cuando insertamos en la base de datos
while (!feof($ar))
  {    
	$lineaSalto=fgets($ar); //Lee una linea del fichero
	$clave="class=\"wcap\""; // Clave que nos indica la linea que nos interesa para coger la fecha
    $clave2="title="; // Clave que nos indica la linea que nos interesa para coger la pelicula

    //Buscamos la clave (la fecha) dentro de la linea
    if (eregi($clave, $lineaSalto)){
        //Elimina todas las etiquetas HTML y PHP de una cadena
		$fecha = strip_tags($lineaSalto);
		//echo $fecha.'<br>';
    }
	//Buscamos la clave2 (el nombre) dentro de la linea
	if (eregi($clave2, $lineaSalto)){
        //Elimina todas las etiquetas HTML y PHP de una cadena
		$nombre = strip_tags($lineaSalto); 
		$i=$i+1;
		//echo $nombre.'<br>';
		
		//Guardamos las peliculas de la cartelera en la base de datos
		insertarDatos($i, $nombre, $fecha);
    }
  }

?>
</body>
</html>	

