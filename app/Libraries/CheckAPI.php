<?php 

namespace App\Libraries;

class CheckAPI {

	public function curp($curp){
		$url = 'http://www.renapo.sep.gob.mx/wsrenapo/MainControllerParam';
		$post = "curp=$curp";

		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

		$htmlContent = curl_exec( $ch );
		// echo $htmlContent."<br/><hr/>";

		preg_match('/<table(.*?)<\/table>/s', $htmlContent, $match);
		$table = $match[0];
		$xml = simplexml_load_string($table);
		$json = json_encode($xml);
		$table = json_decode($json,TRUE);

		// print2($table);
		// print2(htmlspecialchars($response));
		$data = array();
		$data['status'] = 1;
		foreach ($table['tr'] as $k => $tr) {
			if($k == 0){
				continue;
			}
			// print2($tr['td'][0]);

			// echo "<hr/>";
			$td_text = isset($tr['td'][0]['div']) ? $tr['td'][0]['div'] : $tr['td'][0];
			switch ($td_text) {
				case 'Apellido1:':
					$data['Apellido1'] = $tr['td'][1]['div'];
					break;
				case 'Apellido2:':
					$data['Apellido2'] = $tr['td'][1]['div'];
					break;
				case 'AnioReg:':
					$data['AnioReg'] = $tr['td'][1]['div'];
					break;
				case 'Nombres:':
					$data['Nombres'] = $tr['td'][1]['div'];
					break;
				case 'FechNac:':
					$data['FechNac'] = $tr['td'][1]['div'];
					break;
				case 'TipoError:':
					$data['status'] = 0;
					break;
				
				default:
					// code...
					break;
			}
		}

		// print2( $data);
		return $data;

	}

	public function employee_id($employee_id){

		$url = 'http://urlws:puerto/nombrews/consultaemp';
		$post = "IDEMPLEADO=$employee_id";

		// $ch = curl_init( $url );
		// curl_setopt( $ch, CURLOPT_POST, 1);
		// curl_setopt( $ch, CURLOPT_POSTFIELDS, $post);
		// curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		// curl_setopt( $ch, CURLOPT_HEADER, 0);
		// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

		// $resp = curl_exec( $ch );
		// $data = json_decode($resp,true);

		// if(!isset($data['NOMBRE'])){
		// 	return null;
		// }else{
		// 	return $resp;
		// }

		$resp = atj(
			[
				'ID_EMPLEADO' => 'ID_EMPLEADO',
				'NOMBRE' => 'NOMBRE',
				'APELLIDO_1' => 'APELLIDO_1',
				'APELLIDO_2' => 'APELLIDO_2',
				'CORREO' => 'CORREO',
				'ID_C_U_R_P_ST' => 'ID_C_U_R_P_ST',
				'ID_UNIDAD_ADMIN' => 'ID_UNIDAD_ADMIN',
				'DESCRIPCION' => 'DESCRIPCION',
				'ESTATUS' => 'ESTATUS',
				'DESCRIP' => 'DESCRIP',
				'status' => 1,
			]
		);




		return $resp;
	}





}


?>