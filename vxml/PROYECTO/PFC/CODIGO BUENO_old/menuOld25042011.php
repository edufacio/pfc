<?php
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>
<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xmlns:voxeo="http://community.voxeo.com/xmlns/vxml" xml:lang="es-MX"> 
<property name="voicename" value="es-mx-fm3"/> 
<menu>
	<field name="nombre">
	<prompt>
		Bienvenido al sistema de Cine por telefono. 
		Para buscar una pelicula pulse 1 o diga pelicula, Para buscar una pelicula por actor pulse 2 o diga actor, para buscar una pelicula 
		por director pulse 3 o diga director, para oir los estrenos de la semana pulse 4 o diga estrenos, para oir la cartelera pulse 5 
		o diga cartelera.
	</prompt>
	
	<grammar type="text/gsl">
			[uno dos tres cuatro cinco (busqueda por actor) pelicula actor director cartelera estrenos]
	</grammar>
	
	<choice dtmf="1" next="pelicula.php"/>
	<choice dtmf="2" next="actor.php"/>
	<choice dtmf="3" next="director.php"/>
	<choice dtmf="4" next="estrenos.php"/>
	<choice dtmf="5" next="cartelera.php"/> 
	
	<noinput>
	   Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
	   <reprompt/>
	</noinput>
	</field>
	<filled namelist="nombre">
		<if cond="nombre == 'pelicula'">
			<submit next="pelicula.php" method="get" namelist="nombre"/>
		<elseif cond="nombre == 'actor'">
			<submit next="actor.php" method="get" namelist="nombre"/>
		<elseif cond="nombre == 'director'"/>
			<submit next="director.php" method="get" namelist="nombre"/>
		<elseif cond="nombre == 'estrenos'"/>
			<submit next="estrenos.php" method="get" namelist="nombre"/>
		<elseif cond="nombre == 'cartelera'"/>
			<submit next="cartelera.php" method="get" namelist="nombre"/>
		<else/>
		</if> 
    </filled>
</menu>
</vxml>