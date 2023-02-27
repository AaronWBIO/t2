<?php
	
	
	header('Content-Type: text/html; charset=utf-8'); 
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=download.csv");
	$csv = '';
	foreach ($columns as $c){
		$csv .= '"'.$c[0].'", ';
	}

	$csv = rtrim($csv,', ');
	$csv .= "\n";
	foreach ($results as $r){
		foreach ($columns as $c){
			switch($c[2]){
				case 'text':
					$csv .= '"'.$r[$c[1]].'", ';
					break;
				case 'int':
					$csv .= '"'.number_format($r[$c[1]]/$c[3],0,'.',$c[4]).'", ';
					break;
				case 'float':
					$csv .= '"'.number_format($r[$c[1]]/$c[3],2,'.',$c[4]).'", ';
					break;
			}

		}
		$csv = rtrim($csv,', ');
		$csv .= "\n";
	}

	echo $csv;
?>

