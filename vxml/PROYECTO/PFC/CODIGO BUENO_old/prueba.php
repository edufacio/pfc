    <?php
		$titulo="Piratas del Caribe: En mareas misteriosas (Piratas del Caribe 4) (2011)";
		//$titulo="13 de Mayo de 2011 ";
		$cadena='';
		for($j=0;$j<strlen($titulo);$j++){
			if ($titulo[$j] == '\'')
				$cadena=$cadena."\'"; 
			else
				$cadena=$cadena.$titulo[$j];
		}
		
		
		
		//$cadena="Piratas del Caribe: En mareas misteriosas (Piratas del Caribe 4) (2011)";
		$maximo = strlen($cadena);
		echo $maximo.'<br/>';
		//$cadena_comienzo = "search.php";
		$cadena_fin = " (20";
		//$total = strpos($cadena,$cadena_comienzo);
		$total = 0;
		echo $total.'<br/>';
		$total2 = strpos($cadena,$cadena_fin);
		echo $total2.'<br/>';
		$total3 = ($maximo - $total2);
		echo $total3.'<br/>';
		$final = substr ($cadena,$total,-$total3);
		//echo $titulo.'<br/>';
		echo $final.'<br/>';
		
		//$pagSig="http://www.filmaffinity.com/es/$final";
		//echo $pagSig.'<br/>';
		
		/*$nombre2="santiago+segura";
		$nomActor="http://www.filmaffinity.com/es/search.php?stext=$nombre2&stype=all";
		echo $nomActor.'<br/>';*/
    ?>
