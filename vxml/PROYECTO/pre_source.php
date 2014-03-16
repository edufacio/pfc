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
  <var name="preid" expr="session.callerid"/>

 <form id="inicio">
 <field name="dummy0"><property name="timeout" value="1s"/>
 <grammar type="text/gsl">[poppaoomowmow]</grammar>
 <filled><prompt>no way this will ever happen.</prompt></filled>
<noinput>
 <submit next="source.php"  method="get" namelist="preid"/>
<goto next="source.php"/> 
</noinput></field>
</form>
</vxml>