<?php 

namespace App\Libraries;

class Email {

	public function content($params){
		if($params['content']){
			return view('general/'.$params['content'],$params);
		}
	}

	public function send($subject, $message, $toArr = array(), $useTemplate = true){


		$from = "Plataforma de Transporte Limpio <transporte.limpio@semarnat.gob.mx>";
		$subject = "PTL: $subject";



		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From:" . $from . "\r\n";
		// $headers .= "Bcc:" . $from . "\r\n";

		$mail = $message;
		if($useTemplate){
			$data['message'] = $message;
			$data['content'] = "generalMessage";
			$mail = view('general/email',$data);
		}

		if(is_array($toArr)){
			foreach ($toArr as $to) {
				mail($to,$subject,$mail,$headers);
				// echo "mail enviado a $to <br/>";
			}
		}else{
			mail($toArr,$subject,$mail,$headers);
			// echo "mail enviado a $toArr <br/>";
		}

		// echo $mail;


		return true;
	}
	
}


?>