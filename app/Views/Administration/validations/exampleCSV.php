<?php

	header('Content-Type: text/html; charset=utf-8'); 
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=ejemplo.csv");

	$csv = '"Clase - Categoría", "Mínimo absoluto", "Rojo bajo", "Amarillo bajo", "Amarillo alto", "rojo alto", "Máximo absoluto"'."\n";
	foreach ($vclass as $c) {
		foreach ($categories as $cat) {
			$csv .= '"'.$c['name'].'- '.$cat['code'].'", "", "", "", "", "", ""'."\n";
		}
	}
	
	echo $csv;



?>