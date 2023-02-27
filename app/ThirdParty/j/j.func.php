<?php 
// echo "aaa";
// error_reporting(0);
date_default_timezone_set('America/Mexico_City'); 

include_once APPPATH.'ThirdParty/php/i18n_setup.php';


/**
* Imprime objetos de manera ordenada
*
* Funcion para imprimir objetos y arreglos de manera ordenada.
* 
* @param mixed[] $algo 
* @return void
*
*/
function print2($algo, $foo = false) {
	echo '<pre>';
	print_r($algo, $foo);
	echo '</pre>';
}

/**
* Codificador
*
* Cambia la codificación de una cadena a utf8
*
* @param string $str cadena a convertir
* @return string $str cadena codificada en utf8
*
*/
function utf8Str($str){
	$str = mb_convert_encoding($str,"UTF-8");
	return $str;
}


/**

* Codifica a JSON
*
* Codifica un arreglo en formato JSON
*
* @param array $arr Arreglo a convertir en json
* @return string JSON codificación del arreglo en JSON
*
*/
function atj($arr){
	if(is_array($arr)){
		array_walk_recursive($arr, function (&$value) {
			// $value = htmlentities($value);
			$value = $value;
		});
		$j = json_encode($arr);
		return $j;
	}else{
		return $arr;
	}
}




/**
* Sube archivos en la ruta seleccionada
*
* Sube archivos en la ruta seleccionada
*
* @param string $prefijo es el prefijo que va a llevar el archivo al guardarlo;
* @param array $files es el arreglo de archivos a guardar
* @param string $dir Ruta del directorio desde el raiz donde se guardarán los archivos
* @param boolean $evitarNombre Evita usar el nombre original del archivo, sino que solo usa el prefijo y la extensión
* @return string JSON ok = 1 representa que la información fue almacenada correctamente,
* nId es el id con el que fue almacenada la información
*
*/
function uploadFiles($prefijo,$files,$dir){
	$dirO = $dir;
	// $dir = raiz().$dir;


	if(is_array($files['myfile']['name'])){

		$tmp_name = $files["myfile"]["tmp_name"][$key];
		$name = $files["myfile"]["name"];
		move_uploaded_file($tmp_name, "$dir/$prefijo"."$name");
		return '{"ok":1,"nombreArchivo":"'.$name.'","prefijo":"'.$prefijo.'"}';
		
	}else{
		// print2($files);
		// return;
		foreach ($files as $key => $file) {
			$tmp_name = $file["tmp_name"];
			$name = $file["name"];

			$check = 0;
			set_error_handler(function() { 
				$check = 1;
			});
			move_uploaded_file($tmp_name, "$dir/$prefijo"."$name");
			restore_error_handler();
			
			if($check==0)
				return '{"ok":1,"nombreArchivo":"'.$name.'","prefijo":"'.$prefijo.'"}';
			else
				return '{"ok":0,"nombreArchivo":"'.$name.'", "mensaje":"Error en permisos de escritura" }';
		}
	}
}


function getToken($length){
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}

function crypto_rand_secure($min, $max){
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' ){
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
   
    $interval = date_diff($datetime1, $datetime2);
   
    return $interval->format($differenceFormat);   
}

function quantityOrder($a, $b) {
    return $b['quantity'] - $a['quantity'];
}

function monthTranslate($month){
	switch ($month) {
		case 'January':
			return 'enero';
			break;
		case 'February':
			return 'febrero';
			break;
		case 'March':
			return 'marzo';
			break;
		case 'April':
			return 'abril';
			break;
		case 'May':
			return 'mayo';
			break;
		case 'June':
			return 'junio';
			break;
		case 'July':
			return 'julio';
			break;
		case 'August':
			return 'agosto';
			break;
		case 'September':
			return 'septiembre or setiembre';
			break;
		case 'October':
			return 'octubre';
			break;
		case 'November':
			return 'noviembre';
			break;
		case 'December':
			return 'diciembre';
			break;
		
		default:
			# code...
			break;
	}
}

function viewerName($type){
	switch ($type) {
		case 0:
			return 'none';
			break;
		case 1:
			return 'companyViewer';
			break;
		case 2:
			return 'corporationViewer';
			break;
		default:
			# code...
			break;
	}
}


?>
