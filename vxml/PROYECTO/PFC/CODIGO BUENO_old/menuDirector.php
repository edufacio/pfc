<?php
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
?>

<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xmlns:voxeo="http://community.voxeo.com/xmlns/vxml" xml:lang="es-MX">
<?php

header('Cache-Control: no-cache');

?> 

<property name="voicename" value="es-mx-fm3"/> 
	<form id="director">
        <field name="nombre">
        <prompt>
            Por favor, diga el nombre y apellido del director que desea buscar.
        </prompt>
		
		<grammar type="text/gsl">
			[(Woody Allen) (Santiago Segura) (Paco Torres) (Pedro Almodóvar) Almodóvar (Robert Redford) (Steven Spielberg) Spielberg 
			(Charles Chaplin) Chaplin (Quentin Tarantino) Tarantino]
		</grammar>
		
        <filled>
            <submit next="director.php" method="get" namelist="nombre"/>
        </filled>
        <noinput>
           Lo siento, no he entendido lo que ha dicho. Por favor intentelo de nuevo.
           <reprompt/>
        </noinput>
        </field>
    </form>
</vxml>