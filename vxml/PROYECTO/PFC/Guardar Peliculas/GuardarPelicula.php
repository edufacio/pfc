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
/* #######################CAMBIAR LA CONSULTA###################### */
function borrarDatos()
{
	$link=conectarse();
	echo "Conexion satisfactoria a la base de datos";
	
	// Insertamos los datos en la base de datos
	mysql_query("truncate table cartelera",$link);
	echo "Datos borrados".'<br>';
	
	mysql_close($link); //cierra la conexion
}
/* #######################CAMBIAR LA CONSULTA###################### */
function insertarDatos($id, $nombre)
{
	$link=conectarse();
	echo "Conexion satisfactoria a la base de datos";
	
	// Insertamos los datos en la base de datos
	mysql_query("INSERT INTO cartelera (id,nombre) VALUES ('$id','$nombre')",$link);
	echo "Dato insertado".'<br>';
	
	mysql_close($link); //cierra la conexion
}


//Capturamos el contenido de la pelicula de la pagina web y lo guardamos en el fichero "pelicula.txt"

$ch = curl_init("http://www.filmaffinity.com/es/search.php?stext=' . $nombre . '&stype=all");
$fp = fopen("pelicula.txt", "w");

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
		$i=$i+1;
		echo $titulo.'<br>';
		
		//De cada pelicula sacamos todos sus campos: actores, sinopsis...
		//Transformamos el titulo introduciendo un "+" en los espacios en blanco para poder buscar la pelicula en la web
		$nombre='';
		//Empiezo en $j=1 porque me pone un + al principio de la cadena
		for($j=1; $j<strlen($titulo); $j++){
			if ($titulo[$j]==' ')
				$nombre=$nombre."+";
			else
				$nombre=$nombre.$titulo[$j];	
		}
		//echo 'Peli: '.$nombre.'<br>';
		
		//Sacamos la sinopsis de la pelicula
		
		//Guardamos las peliculas de la cartelera en la base de datos
		insertarDatos($i, $titulo);
    }
  }
 
?>

