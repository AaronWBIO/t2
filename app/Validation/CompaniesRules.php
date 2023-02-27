<?php 


namespace App\Validation;
use App\Models\Empresas\CompaniesModel;


class CompaniesRules{

	public function validateUser(String $str, String $fields, array $data){

		// $messagesModel = new MessagesModel();

		$model = new CompaniesModel();
		$user = $model->where('rfc',$data['username'])->first();

		// print2($user);

		if(!$user){
			return false;
		}

		$pwdVerif =  password_verify($data['password'], $user['password']);


		if($pwdVerif){
			return true;
		}else{

			// $newData = [
			// 	'id' => $user['id'],
			// 	'attempts' => $user['attempts']+1,
			// ];
			// // echo "BBB";
			// if($user['attempts']+1 == 4){
			// 	$newData['status'] = 30;
			// }
			// // print2($newData);
			// $model -> save($newData);


			// if($newData['attempts'] == 4){
			// 	$message = $messagesModel -> where('name','multipleLoginAttempts') -> first();
			// 	$message['message'] = str_replace('[recoverPwdUrl]', base_url()."/forgotPwd", $message['message']);
			// 	$message['email'] = str_replace('[email]', $data['email'], $message['message']);

			// 	$email -> send($message['subject'], $message['message'], [$data['email']],true,true);
			// }


			return false;
		}
	}

	public function validateUserStatus(String $str, String $fields, array $data){

		// $messagesModel = new MessagesModel();

		$model = new CompaniesModel();
		$user = $model->where('rfc',$data['username'])->first();

		// print2($user);

		if(!$user){
			return false;
		}

		$pwdVerif =  password_verify($data['password'], $user['password']);


		if($user['status'] == 2){
			return false;
		}else{


			return true;
		}
	}

	public function RFC(String $nra){
		$v = "/^[a-zA-Z&]{3}([a-zA-Z&]{1})?[0-9]{6}[a-zA-Z0-9]{3}/";
		return preg_match($v, $nra) == 1;
	}



}

