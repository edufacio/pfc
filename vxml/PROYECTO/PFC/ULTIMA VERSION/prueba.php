<?php
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>

<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml"  xml:lang="es-es">

<?php
header('Cache-Control: no-cache');
?> 

<form id="MainMenu">
	<field name="cine">
	<prompt>
		Bienvenido al sistema de Cine por telefono. 
		Para buscar una pelicula pulse 1 o diga pelicula, Para buscar una pelicula por actor pulse 2 o diga actor, para buscar una pelicula 
		por director pulse 3 o diga director, para oir los estrenos de la semana pulse 4 o diga estrenos, para oir la cartelera pulse 5 
		o diga cartelera.
	</prompt>
	
	<grammar type="text/gsl">
		[uno dos tres cuatro cinco pelicula]
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
