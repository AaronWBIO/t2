
<?php

header('Content-Type: text/html; charset=utf-8'); 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Empresas registradas.csv");

$csv = '';
$csv .= '"Nombre"';
$csv .= ',"RFC"';
$csv .= ',"Tipo"';
$csv .= ',"Estatus"';
$csv .= ',"Correo electrónico"';
$csv .= ',"Dirección web"';
$csv .= ',"Dirección"';
$csv .= ',"Estado"';
$csv .= ',"Municipio"';
$csv .= ',"CP"'."\n";

foreach ($list as $e) {

	$csv .= '"'.$e['name'].'"';
	$csv .= ',"'.$e['rfc'].'"';
	switch ($e['type']) {
		case '1':
			$csv .= ',"Transportista"';
			break;
		case '2':
			$csv .= ',"Usuaria de transporte de carga"';
			break;

		default:
			# code...
			break;
	}
	switch ($e['status']) {
		case '2':
			$csv .= ',"Inactivo"';
			break;
		case '1':
			$csv .= ',"Activo"';
			break;

		default:
			# code...
			$csv .= ',"Activo"';
			break;
	}

	$csv .= ',"'.$e['email'].'"';
	$csv .= ',"'.$e['website'].'"';
	$csv .= ',"'.$e['direccion'].'"';
	$csv .= ',"'.$e['estadoNombre'].'"';
	$csv .= ',"'.$e['municipioNombre'].'"';
	$csv .= ',"'.$e['cp'].'"';
	$csv .= "\n";
}

echo $csv;

?>