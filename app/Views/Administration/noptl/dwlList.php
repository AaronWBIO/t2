
<?php

header('Content-Type: text/html; charset=utf-8'); 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=NO-PTL.csv");

$csv = '';
$csv .= '"Nombre"';
$csv .= ',"CO2GKM"';
$csv .= ',"NOXGKM"';
$csv .= ',"PM25GKM"';
$csv .= ',"PM10GKM"';
$csv .= ',"CNGKM"';
$csv .= ',"CO2GTonKM"';
$csv .= ',"NOXGTonKM"';
$csv .= ',"PM25GTonKM"';
$csv .= ',"PM10GTonKM"';
$csv .= ',"CNGTonKM"';
// $csv .= ',"CO2"';
// $csv .= ',"NOX"';
// $csv .= ',"PM10"';
// $csv .= ',"PM25"';
// $csv .= ',"CN"';
$csv .= "\n";

foreach ($fleets as $e) {

	$csv .= '"'.$e['name'].'"';
	$csv .= ',"'.$e['CO2GKM'].'"';
	$csv .= ',"'.$e['NOXGKM'].'"';
	$csv .= ',"'.$e['PM25GKM'].'"';
	$csv .= ',"'.$e['PM10GKM'].'"';
	$csv .= ',"'.$e['CNGKM'].'"';
	$csv .= ',"'.$e['CO2GTonKM'].'"';
	$csv .= ',"'.$e['NOXGTonKM'].'"';
	$csv .= ',"'.$e['PM25GTonKM'].'"';
	$csv .= ',"'.$e['PM10GTonKM'].'"';
	$csv .= ',"'.$e['CNGTonKM'].'"';
	// $csv .= ',"'.$e['CO2'].'"';
	// $csv .= ',"'.$e['NOX'].'"';
	// $csv .= ',"'.$e['PM10'].'"';
	// $csv .= ',"'.$e['PM25'].'"';
	// $csv .= ',"'.$e['CN'].'"';
	$csv .= "\n";
}

echo $csv;

?>