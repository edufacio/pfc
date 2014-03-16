<html>
<head>
	<title>Ejemplo de PHP: Insertar datos en la BBDD</title>
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
	echo "Conexion satisfactoria a la base de datos";
	
	// Borramos los datos en la base de datos
	mysql_query("truncate table genero",$link);
	echo "Datos borrados".'<br>';
	
	mysql_close($link); //cierra la conexion
}

function insertarDatos($id, $nombre)
{
	$link=conectarse();
	echo "Conexion satisfactoria a la base de datos";
	
	// Insertamos los datos en la base de datos
	mysql_query("INSERT INTO genero (id,nombre) VALUES ('$id','$nombre')",$link);
	echo "Dato insertado".'<br>';
	
	mysql_close($link); //cierra la conexion
}

//Borramos los datos de la tabla director
borrarDatos();

//Abrimos el fichero que tiene la infirmacion en modo lectura
$ar=fopen("genero.txt","r") or
    die("No se pudo abrir el archivo");
	
$i=0; // Variable para indicar el ID cuando insertamos en la base de datos
while (!feof($ar))
  {    
	$lineaSalto=fgets($ar); //Lee una linea del fichero
	$i=$i+1;
    //Guardamos los directores en la base de datos
	insertarDatos($i, $lineaSalto); 
  }
fclose($ar);
?>
</body>
</html>	

