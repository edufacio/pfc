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
$numero = 151621;
//$numero = 107264;
//while($numero<1000000){
	//Capturamos el contenido de la pagina web y lo guardamos en una variable
	//$url = fopen("http://www.filmaffinity.com/es/film$numero.html", "r");
	/*$url = fopen("http://www.google.es", "r");
	if($url)
	{
		//echo "Entra";
		$texto="";
		while(!feof($url)){
			$texto .= fgets($url, 1024);
		}
	}*/
	
	
	//OTRA FORMA DE HACERLO
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://www.filmaffinity.com/es/film$numero.html');
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$texto = curl_exec($ch);
	$error = curl_error($ch);
	curl_close($ch);
	echo $texto;
	echo $error;
	
	$lineas = explode("\n", $texto);
	for($y=0; $y<=count($lineas); $y++){
		$clave="ORIGINAL"; // Clave que nos indica la linea que nos interesa
		echo 'Linea '.$y.$lineas[$y].'<br>';
		if (eregi($clave, $lineas[$y])){  //Buscamos una clave dentro de la linea
			//Leemos otra linea del fichero porque la que nos interesa es la siguiente a la que contiene la clave
			$titulo = strip_tags($lineas[$y+1]); //Elimina todas las etiquetas HTML y PHP de una cadena	
			
			//Controlo el apostrofe ' de las palabras en ingles, para que se pueda insertar en la bbdd
			$nombre='';
			for($j=0;$j<strlen($titulo);$j++){
				if ($titulo[$j] == '\'')
					$nombre=$nombre."\'"; 
				else
					$nombre=$nombre.$titulo[$j];
			}
			insertarDatos($numero, $nombre);
		}
	}
	
	$numero=$numero+1;
//}

echo 'FIN';
?>