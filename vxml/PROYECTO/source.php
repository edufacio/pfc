<?php
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>

<vxml version="2.1" xmlns:voxeo="http://community.voxeo.com/xmlns/vxml" xml:lang="es-es">
<?php

header('Cache-Control: no-cache');

?> 
  <property name="grammarfetchint" value="prefetch"/>
    <catch event="connection.disconnect.hangup">
    <exit/>
  </catch>
<var name="seccion"/>
   <?   
$id = $_REQUEST["preid"];  

$mysql_host = "mysql3.000webhost.com";
$mysql_database = "a3571710_cine";
$mysql_user = "a3571710_aceves";
$mysql_password = "jose26284";

mysql_connect($mysql_host,$mysql_user,$mysql_password);
@mysql_select_db($mysql_database) or die ("No se pudo conectar con la base de datos");

$result = mysql_query("SELECT * FROM actor WHERE nombre='uno'");

$num=mysql_numrows($result);

while ($dato = mysql_fetch_array($result))
{	$id='ID: '.$dato['id']."\n";
	$nombre='Nombre: '.$dato['nombre']."\n";
}

mysql_close();

  ?> 
<form id="viejo_usuario">
  <field name="servidor">
  <prompt>
  Hola estamos en el servidor externo.
  </prompt>
  </field>

	</form>	
</vxml>