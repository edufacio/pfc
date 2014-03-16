<?php
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
?>

<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml"  xml:lang="es-es">

<?php
header('Cache-Control: no-cache');
?> 
	<form id="pelicula">
        <field name="nombre">
        <prompt>
            Por favor, diga el titulo de la pelicula que desea buscar.
        </prompt>
		
		<grammar type="text/gsl">
			[(un cuento chino) (todo sobre mi madre) (la mala educacion) (la bruja novata) infiltrados (gran torino) 
			(mar adentro)]
		</grammar>
		
        <filled>
            <submit next="comprobarPelicula.php" method="get" namelist="nombre"/>
        </filled>
        <noinput>
           Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
           <reprompt/>
        </noinput>
        </field>
    </form>
</vxml>