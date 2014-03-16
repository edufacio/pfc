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
	mysql_query("truncate table peliculas",$link);
	echo "Datos borrados".'<br>';
	
	mysql_close($link); //cierra la conexion
}

function insertarDatos($num, $titulo)
{
	$link=conectarse();
	//echo "Conexion satisfactoria a la base de datos";
	
	// Insertamos los datos en la base de datos
	mysql_query("INSERT INTO peliculas (id, nombre) VALUES ('$num','$titulo')",$link);
	//echo $i.' Dato insertado: '.$titulo.'<br>';
	
	mysql_close($link); //cierra la conexion
}

//borrarDatos();
//Generamos numeros de 6 digitos 100000-999999 para ir buscando peliculas
$numero = 136640;
//$numero = 151621;
while($numero<1000000){
		
	$ch = curl_init("http://www.google.es");
	$fp = fopen("pelicula.txt", "w");

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	curl_exec($ch);
	curl_close($ch);

	fclose($fp);

	
	//OTRA FORMA DE CAPTURAR EL CONTENIDO DE LA PAGINA WEB
/*
	$url = fopen("http://www.filmaffinity.com/es/film$numero.html", "r");

	if($url)
	{
		echo "Entra";
		$texto="";
		while(!feof($url)){
			$texto .= fgets($url, 1024);
		}
		$fp = fopen("pelicula.txt", "w");//Abrimos el fichero en modo escritura
		fputs($fp,$texto);
		fclose($fp);
	}
	*/
	
	//Abrimos el fichero en modo lectura
	$ar=fopen("pelicula.txt","r") or
		die("No se pudo abrir el archivo");
	//$bandera=0; //Para parar de leer el fichero xq ya hemos encontrado lo que buscamos
	while (!feof($ar))
	  {
		$lineaSalto=fgets($ar); //Lee una linea del fichero
		$clave="ORIGINAL"; // Clave que nos indica la linea que nos interesa
		
		if (eregi($clave, $lineaSalto)){  //Buscamos una clave dentro de la linea
			$lineaSalto=fgets($ar); //Leemos otra linea del fichero porque la que nos interesa es la siguiente a la que contiene la clave
			$titulo = strip_tags($lineaSalto); //Elimina todas las etiquetas HTML y PHP de una cadena	
			
			//Controlo el apostrofe ' de las palabras en ingles, para que se pueda insertar en la bbdd
			$nombre='';
			for($j=0;$j<strlen($titulo);$j++){
				if ($titulo[$j] == '\'')
					$nombre=$nombre."\'"; 
				else
					$nombre=$nombre.$titulo[$j];
			}
			//$array[]= $nombre; //Guardamos en un array las peliculas
			insertarDatos($numero, $nombre);
			echo $nombre;
			//$bandera=1;
		}
	  }
	fclose($ar); 
	unlink('pelicula.txt'); //Eliminamos el archivo del servidor para que no de problemas
	$numero=$numero+1;
}

echo 'FIN';
?>