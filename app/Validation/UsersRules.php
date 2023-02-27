<?php 


namespace App\Validation;
use App\Models\Administration\UsersModel;


class UsersRules{

	public function validateInternalUser(String $str, String $fields, array $data){

		// $messagesModel = new MessagesModel();

		$model = new UsersModel();
		$user = $model->where('username',$data['username'])->first();

		if(!$user){
			return false;
		}

		$pwdVerif =  password_verify($data['password'], $user['password']);

		if($user['status']<100){
			$pwdVerif = false;			
		}

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


}

