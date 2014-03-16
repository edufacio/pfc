<?php

/*Sacamos las peliculas de la cartelera y las guardamos en un array para poder ir leyendoselas al usuario y crear una gramtica con ellas tambien*/

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

$link=Conectarse(); //Nos conectamos a la base de datos
mysql_select_db($mysql_database, $link);

//Consulta para sacar las peliculas de la cartelera de la BD
$consulta = mysql_query("SELECT nombre FROM cartelera");

while ($dato = mysql_fetch_array($consulta))
{	
	//Guardamos en un ARRAY los nombre de las peliculas
	$nombre[]='Nombre: '.$dato['nombre']."\n";
	//echo 'ID: '.$id; 
	//echo '<br>Nombre/pelicula: '.$nombre.'<br>';
}

/*for($i=0;$i<count($nombre);$i++)
	echo $i.': '.$nombre[$i].'<br>';
*/
mysql_close($link); //cierra la conexion

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>


<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xmlns:voxeo="http://community.voxeo.com/xmlns/vxml" xml:lang="es-MX"> 

<form>
<block>
   
	<field name="pelicula">
		
		//COMPROBAR COMO FUNCIONA ESTO
		<grammar src="dynamic.cfm#PELICULA" type="text/gsl"/>
		
		
		<prompt>
			Estas son las peliculas que hay en cartelera, si quiere informacion de alguna de ella diga el nombre completo de la pelicula
			<?php
				for($i=0;$i<count($nombre);$i++)
					echo $nombre[$i];
			?>
		</prompt>

		<filled>
		
		//EJEMPLO PARA VER COMO LO HACE
		
		   <if cond="Kubrick == 'two thousand one'">
			  Open the pod bay doors hal.
		   <elseif cond="Kubrick == 'clockwork orange'"/>
			  Viddy well, little droogies.
		   <elseif cond="Kubrick == 'doctor strangelove'"/>
			  Precious. Bodily. Fluids!
		  <elseif cond="Kubrick == 'the killing'"/>
			  Put the money in the bag!
		  <elseif cond="Kubrick == 'lolita'"/>
			  Humbert Humbert is thinking bad thoughts.
		  <elseif cond="Kubrick == 'barry lydon'"/>
			  Pistol duelling is best left to those who can hit what they aim at.
		  <elseif cond="Kubrick == 'day of the fight'"/>
			  Put up your dukes.
		  <elseif cond="Kubrick == 'the shining'"/>
			  Danny's not here missus Torrance!
		   <else/>
		   </if>
		</filled>   
	</field>
  
</block>
</form>

</vxml>