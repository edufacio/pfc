<?php
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>
<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xmlns:voxeo="http://community.voxeo.com/xmlns/vxml" xml:lang="es-MX"> 
<?php
header('Cache-Control: no-cache');
?> 
<property name="voicename" value="es-mx-fm3"/> 
<form id="MainMenu">
	<field name="cine">
	<prompt>
		Bienvenido al sistema de Cine por telefono. 
		Para buscar una pelicula pulse 1 o diga pelicula, Para buscar una pelicula por actor pulse 2 o diga actor, para buscar una pelicula 
		por director pulse 3 o diga director, para oir los estrenos de la semana pulse 4 o diga estrenos, para oir la cartelera pulse 5 
		o diga cartelera.
	</prompt>
	
	<grammar type="text/gsl">
		[uno dos tres cuatro cinco pelicula dtmf-1 dtmf-2 dtmf-3 dtmf-4 dtmf-5 dtmf-6 dtmf-6 dtmf-7 dtmf-8 dtmf-9 dtmf-0]
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
			<submit next="menuActor.php" method="get" namelist="cine"/>
		<elseif cond="cine == 'dos'"/>
			<submit next="menuActor.php" method="get" namelist="cine"/>
		<elseif cond="cine == 'tres'"/>
			<submit next="menuActor.php" method="get" namelist="cine"/>
		<elseif cond="cine == 'cuatro'"/>
			<submit next="menuActor.php" method="get" namelist="cine"/>
		<elseif cond="cine == 'cinco'"/>
			<submit next="menuActor.php" method="get" namelist="cine"/>
      </if> 
    </filled>
</form>
</vxml>