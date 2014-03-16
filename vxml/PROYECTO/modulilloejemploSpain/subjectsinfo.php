<?php  

/*Obtenemos el valor de la titulación*/
$subject = $_GET["subject"]; 
$subject1 = $_GET["visualsubject"];

/*abrimos el fichero de la pagina resultado*/
$fichero="resultado_asignatura.xhtml";
$resultado=fopen($fichero,w);


/*--------------------BBDD--------------------------------------*/
/*Obtenemos los datos correspondientes de la base de datos*/
$link = mysql_connect("localhost", "root", "vertrigo");
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
if(!mysql_select_db("bbdd_pfc",$link)) 
     die("No database selected."); 
$result = mysql_query("SELECT cod_asignatura, nombre_asignatura, curso, curso_academico, cuatrimestre, prof_coordinador, cont_programa, sist_evaluacion, bibliografia, type_subject, asignatura FROM info_asignatura where nombre_asignatura='$subject1' or nombre_asignatura='$subject'", $link); 
if (!$result) {
    die('Could not query:' . mysql_error());
}
/*Mostramos los resultados de la consulta*/
$row = mysql_fetch_row($result);
/*--------------------BBDD--------------------------------------*/





/*parte voz xml*/
fwrite($resultado,'<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xv="http://www.voicexml.org/2002/xhtml+voice" xmlns:vxml="http://www.w3.org/2001/vxml" xmlns:ev="http://www.w3.org/2001/xml-events">'); 
fwrite($resultado,'<head>'); 
fwrite($resultado,'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />');
fwrite($resultado,'<meta name="language" content="es"/>');
fwrite($resultado,'<link rel="stylesheet" type="text/css" href="default.css" media="screen"/>'); 
  fwrite($resultado,'<title>Example #: Integrate xhtml in php</title>'); 
  fwrite($resultado,'<form xmlns="http://www.w3.org/2001/vxml" id="prove1">'); 
    fwrite($resultado,'<field name="subject">'); 
      fwrite($resultado,'<prompt>Below is the information requested. Say return to go to the previous page</prompt>'); 
      fwrite($resultado,'<option value="Return">Return</option>'); 
	  fwrite($resultado,'<nomatch>Try again.</nomatch>'); 
	  fwrite($resultado,'<filled>'); 
	    fwrite($resultado,'You wil return to the last page 
        <assign name="window.location" expr="\'http://localhost/PFC/informacion_asignatura_def.xhtml\'"/>'); 
	  fwrite($resultado,'</filled>'); 
   fwrite($resultado,'</field>'); 
  fwrite($resultado,'</form>'); 
fwrite($resultado,'</head>'); 
fwrite($resultado,'<body ev:event="load" ev:handler="#prove1">'); 

fwrite($resultado,'<div class="main-left">'); 
fwrite($resultado,'<div class="header">'); 
fwrite($resultado,'<h2><span>20 aniversario UC3M</span></h2>'); 
fwrite($resultado,'<h1>Carlos III University</h1>'); 
fwrite($resultado,'</div>'); 
fwrite($resultado,'<div class="content">');
fwrite($resultado,'<h1 align="left" style="color:black;font-size:20px;font-family:Verdana;">'); 
fwrite($resultado,$row[1]); 
fwrite($resultado,' information'); 
fwrite($resultado,'<br/><br/>'); 
fwrite($resultado,'</h1>');
fwrite($resultado,'<h1 align="left" style="color:black;font-size:16px;font-family:Verdana;">You have requested information for '); 
fwrite($resultado,$row[1]);
fwrite($resultado,'.<br/><br/>'); 
fwrite($resultado,'</h1>'); 
fwrite($resultado,'<h1 align="left" style="color:black;font-size:16px;font-family:Verdana;"><b>-Subject Code: </b>'); 
fwrite($resultado,$row[0]);
fwrite($resultado,'.</h1>'); 
fwrite($resultado,'<br/>'); 
fwrite($resultado,'<h1 align="left" style="color:black;font-size:16px;font-family:Verdana;"><b>-Type of Subject: </b>'); 
fwrite($resultado,$row[9]);
fwrite($resultado,'.</h1>'); 
fwrite($resultado,'<br/>'); 
fwrite($resultado,'<h1 align="left" style="color:black;font-size:16px;font-family:Verdana;"><b>-Course director: </b>'); 
fwrite($resultado,$row[5]);
fwrite($resultado,'.</h1>');
fwrite($resultado,'<br/>'); 
fwrite($resultado,'<h1 align="left" style="color:black;font-size:16px;font-family:Verdana;"><b>-Course: </b>'); 
fwrite($resultado,$row[2]);
fwrite($resultado,'.</h1>');
fwrite($resultado,'<br/>'); 
fwrite($resultado,'<h1 align="left" style="color:black;font-size:16px;font-family:Verdana;"><b>-Period: </b>'); 
fwrite($resultado,$row[4]);
fwrite($resultado,'.</h1>');
fwrite($resultado,'<br/>'); 
fwrite($resultado,'<h1 align="left" style="color:black;font-size:16px;font-family:Verdana;"><b>-Academic Course: </b>'); 
fwrite($resultado,$row[3]);
fwrite($resultado,'.</h1>');
fwrite($resultado,'<br/>'); 
fwrite($resultado,'<h1 align="left" style="color:black;font-size:16px;font-family:Verdana;"><b>-Academic Program: </b>'); 
fwrite($resultado,'<br/>'); 
fwrite($resultado,nl2br($row[6]));
fwrite($resultado,'</h1>');
fwrite($resultado,'<br/>'); 
fwrite($resultado,'<h1 align="left" style="color:black;font-size:16px;font-family:Verdana;"><b>-Evaluation System: </b>'); 
fwrite($resultado,'<br/>'); 
fwrite($resultado,nl2br($row[7]));
fwrite($resultado,'<br/>'); 
fwrite($resultado,'</h1>');
fwrite($resultado,'<br/>');
fwrite($resultado,'<h1 align="left" style="color:black;font-size:16px;font-family:Verdana;"><b>-Bibliography: </b>'); 
fwrite($resultado,'<br/>'); 
fwrite($resultado,nl2br($row[8]));
fwrite($resultado,'.</h1>');
fwrite($resultado,'<br/>'); 
fwrite($resultado,'<br/>'); 
fwrite($resultado,'<br/>'); fwrite($resultado,'<br/>'); fwrite($resultado,'<br/>'); fwrite($resultado,'<br/>'); fwrite($resultado,'<br/>'); 
fwrite($resultado,'<br/>'); fwrite($resultado,'<br/>'); fwrite($resultado,'<br/>'); fwrite($resultado,'<br/>'); fwrite($resultado,'<br/>'); 
fwrite($resultado,'</div>'); 
fwrite($resultado,'<input type="button" style="font-size:10px;font-family:Verdana,Helvetica;
        font-weight:bold;
        color:white;
        background:#638cb5;
        border:0px;
        width:80px;
        height:19px;" value="Back" onclick="history.go(-1)">'); 
fwrite($resultado,'</input>');
fwrite($resultado,'</div>'); 	
fwrite($resultado,'<div class="nav">'); 
	
	fwrite($resultado,'<div class="logo"><span></span></div>'); 

	fwrite($resultado,'<ul>'); 
		fwrite($resultado,'<li><a href="principal.xhtml">Home</a></li>'); 
		fwrite($resultado,'<li><a href="http://localhost/PFC/informacion_titulacion_def.xhtml">Bachelors Degree Information</a></li>'); 
		fwrite($resultado,'<li><a href="http://localhost/PFC/ayuda_elegir_grado.xhtml">Which degree should I choose?</a></li>'); 
		fwrite($resultado,'<li><a href="informacion_asignatura_def.xhtml">Subjects Information</a></li>'); 
		fwrite($resultado,'<li><a href="informacion_titulacion_def.xhtml">Bachelors Degree Information</a></li>'); 
		fwrite($resultado,'<li><a href="opinion.xhtml">Your Opinion on UC3M</a></li>'); 
		fwrite($resultado,'<li><a href="survey.xhtml">Opera Voice Survey</a></li>'); 
	fwrite($resultado,'</ul>'); 

fwrite($resultado,'</div>'); 

fwrite($resultado,'<div class="main-right">'); 

	fwrite($resultado,'<div class="round">'); 		
		fwrite($resultado,'<div class="roundtl"><span></span></div>'); 
		fwrite($resultado,'<div class="roundtr"><span></span></div>'); 
		fwrite($resultado,'<div class="clearer"><span></span></div>'); 
	fwrite($resultado,'</div>'); 

	fwrite($resultado,'<div class="subnav">'); 

		fwrite($resultado,'<h1>About us</h1>'); 
		fwrite($resultado,'<ul>'); 
			fwrite($resultado,'<li><a href="index.html">Telephone</a></li>'); 
			fwrite($resultado,'<li><a href="index.html">Email</a></li>'); 
			fwrite($resultado,'<li><a href="index.html">Map</a></li>'); 
		fwrite($resultado,'</ul>'); 
		fwrite($resultado,'<h1>Legal Terms</h1>'); 
		fwrite($resultado,'<h1>Copyright</h1>'); 
		fwrite($resultado,'<h1>Site Map</h1>'); 
		
	fwrite($resultado,'</div>'); 

	fwrite($resultado,'<div class="round">'); 
		fwrite($resultado,'<div class="roundbl"><span></span></div>'); 
		fwrite($resultado,'<div class="roundbr"><span></span></div>'); 
		fwrite($resultado,'<span class="clearer"></span>'); 
	fwrite($resultado,'</div>'); 
fwrite($resultado,'</div>'); 
fwrite($resultado,'</body>'); 
fwrite($resultado,'</html>'); 
/*parte voz xml*/


/*cierro la bbdd*/
mysql_close($link);
fclose($resultado);
header("location: http://localhost/PFC/resultado_asignatura.xhtml");





?>


	fwrite($resultado,'<div class="round">'); 
		fwrite($resultado,'<div class="roundbl"><span></span></div>'); 
		fwrite($resultado,