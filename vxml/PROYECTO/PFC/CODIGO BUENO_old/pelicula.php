<?php
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>

<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xmlns:voxeo="http://community.voxeo.com/xmlns/vxml" xml:lang="es-MX">
<?php

header('Cache-Control: no-cache');

?> 

<property name="voicename" value="es-mx-fm3"/> 
	<form id="pelicula">
        <field name="nombre">
        <prompt>
            Por favor, diga el nombre de la pelicula que desea buscar.
        </prompt>
		
		<grammar type="text/gsl">
			[Thor (Agua para elefantes) (The Fast & Furious 5) (A todo gas 5) (No tengas miedo) (En un mundo mejor) (Torrente 4: Lethal Crisis) 
			(Torrente 4) (Cisne negro) (The Symmetry) (The Symmetry of Love) (El sicario de Dios) (El último exorcismo)]
		</grammar>
		
        <filled>
            <submit next="leerPelicula.php" method="get" namelist="nombre"/>
        </filled>
        <noinput>
           Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
           <reprompt/>
        </noinput>
        </field>
    </form>
</vxml>