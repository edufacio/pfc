<?php

preg_match_all('/<a href="\/es\/film[0-9]+\.html".*<\/a>/',file_get_contents($nombreDeArchivo), $arrayCoincidencias);


var_dump($arrayCoincidencias);

$urls =array();
foreach ($arrayCoincidencias[0] as $linea) {
        $peli = array();

        $peli['Nombre']=strip_tags($linea);

        preg_match('/".*"/',$linea, $matches);
        $peli['Url'] = str_replace('"','',$matches[0]);
        $urls[] = $peli;
}
var_dump($urls);
