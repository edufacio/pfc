<?php
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
?>

<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml"  xml:lang="es-es">

<?php
header('Cache-Control: no-cache');
?> 


<form id="MainMenu">
	<field name="cine">
	<prompt>
		Bienvenido al sistema de cine por telefono. 
		Estas en el menu principal. ¿Que te interesa?. 
		Si desea informacion de una pelicula, diga pelicula. 
		Si desea informacion de la cartelera, diga cartelera. 
		Si desea informacion de los proximos estrenos, diga estrenos.
	</prompt>
	
	<grammar type="text/gsl">
		[pelicula cartelera estrenos]
	</grammar>
		
	<noinput>
		Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
		<reprompt/>
	</noinput>
	
	<nomatch>
		Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
		<reprompt/>
	</nomatch>
	  
	</field>
	
	<filled namelist="cine">
      <if cond="cine == 'pelicula'">
			<submit next="pelicula.php" method="get" namelist="cine"/>
		<elseif cond="cine == 'dos'"/>
			<submit next="pelicula.php" method="get" namelist="cine"/>
		<elseif cond="cine == 'tres'"/>
			<submit next="pelicula.php" method="get" namelist="cine"/>
		<elseif cond="cine == 'cuatro'"/>
			<submit next="pelicula.php" method="get" namelist="cine"/>
		<elseif cond="cine == 'cinco'"/>
			<submit next="pelicula.php" method="get" namelist="cine"/>
      </if> 
    </filled>
</form>
</vxml>