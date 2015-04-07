<?
$a = "paco martinez  soria";

$aArr = explode(" ", $a);

var_dump(preg_replace("/\s+/","+", $a));
var_dump($aArr);
var_dump(implode("+",$aArr));

