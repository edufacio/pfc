<?php

$mysql_host = "sql109.arredemo.org";
$mysql_database = "adm_7308952_cine";
$mysql_user = "adm_7308952";
$mysql_password = "jose26284";

function Conectarse()
{
	$mysql_host = "sql109.arredemo.org";
	$mysql_database = "adm_7308952_cine";
	$mysql_user = "adm_7308952";
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
}

$link=Conectarse(); //Nos conectamos a la base de datos
//echo "Conexión con la base de datos conseguida <br>";

mysql_select_db($mysql_database, $link);

//Consulta para sacar la informacion que necesitamos de la BD
$consulta = mysql_query("SELECT * FROM actor WHERE nombre= '" . $_REQUEST["nombre"] . "'");

//$consulta = mysql_query("SELECT * FROM actor where nombre='uno'");

//Guardamos los datos de la consulta en un archivo
//Abrimos el fichero en modo de escritura 
$FicheroSalida = fopen("fichero_salida.vxml","w"); 

//Escribimos la cabecera del documento VXML
$cabecera="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>
<vxml version=\"2.0\" xmlns=\"http://www.w3.org/2001/vxml\" xmlns:voxeo=\"http://community.voxeo.com/xmlns/vxml\"  xml:lang=\"es-MX\">
<property name=\"voicename\" value=\"es-mx-fm3\"/>
<form>\n<block>\n<prompt>\n";
fputs($FicheroSalida,$cabecera);

//Escribimos en el fichero los datos que nos devuelve la consulta
$ndir = mysql_num_rows($consulta);
//echo 'Numero de filas: '.$ndir.'<br>';
while ($dato = mysql_fetch_array($consulta))
{	$id='ID: '.$dato['id']."\n";
	$nombre='Nombre: '.$dato['nombre']."\n";
	//echo 'ID: '.$id; 
	//echo '<br>Nombre/pelicula: '.$nombre.'<br>';
	#Escribimos en el fichero
	fputs($FicheroSalida,$id);
	fputs($FicheroSalida,$nombre); 

}
//Escribimos el final del fichero VXML
$final="</prompt>\n</block>\n</form>\n</vxml>";
fputs($FicheroSalida,$final);

mysql_close($link); //cierra la conexion

fclose($FicheroSalida); //Cerramos el fichero 

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>


<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xmlns:voxeo="http://community.voxeo.com/xmlns/vxml" xml:lang="es-MX"> 

<form>
<block>
  <prompt>
    <?php echo $nombre;?>
  </prompt>
</block>
</form>

</vxml>
