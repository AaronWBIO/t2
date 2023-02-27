<?php
namespace App\Controllers\Administration;
use App\Models\Administration\UsersModel;

use App\Controllers\BaseController;
include_once APPPATH.'/ThirdParty/j/j.func.php';

class Users extends BaseController{

	public function index(){

	    $data['title'] = 'Usuarios internos';
	    $data['content'] = 'Administration/users/index';

	    echo view('layout/base',$data);
	}

	public function addForm(){
		// echo '$type';
		$data = [];

		helper(['form']);
		// print2($data['estados']);

		echo view('Administration/users/addForm',$data);
	}

	public function edtForm($users_id){
		$data = [];


		helper(['form']);

		$model = new UsersModel();

		$data['user'] = $model ->where('id',$users_id)->first();
		$data['users_id'] = $users_id;

		// print2($data['company']);

		echo view('Administration/users/edtForm',$data);
	}

	public function add(){


		if ($this->request->getMethod() == 'post') {
			// Validation;
			$rules = [
				'name' => 'required|min_length[3]',
				'username' => 'required|min_length[3]|max_length[50]|is_unique[Users.username]',
				'password' => 'required|min_length[9]',
				'email' => 'required|valid_email|is_unique[Users.email]',

			];

			$errors = [
				'name' => [
					'required' => 'El nombre es obligatorio',
					'min_length' => 'El nombre debe contener al menos 3 caracteres',
				],
				'username' => [
					'required' => 'El nombre de usuario es obligatorio',
					'min_length' => 'El nombre de usuario debe contener al menos 3 caracteres',
					'max_length' => 'El nombre de usuario debe contener a lo más 50 caracteres',
				],
				'password' => [
					'required' => 'La contraseña es obligatoria',
					'min_length' => 'La contraseña debe tener al menos 9 caracteres',
				],
				'email' => [
					'required' => 'El correo electrónico es obligatorio',
					'valid_email' => 'Correo electrónico inválido',
					'is_unique' => 'El correo electrónico ya existe en la base de datos',
				],
			];

			// print2($_POST);
			if(!$this->validate($rules,$errors)){
				$r = [];
				$r['ok'] = 2;
				$r['err'] = $this->validator->listErrors();

				return(atj($r));
			}else{
				// Store user un DB
				$model = new UsersModel();

				$password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);

				$corporations_id = empty($this->request->getVar('corporations_id'))?null:$this->request->getVar('corporations_id');
				$newData = [
					'username' => $this->request->getVar('username'),
					'password' => $password,
					'email' => $this->request->getVar('email'),
					'name' => $this->request->getVar('name'),
					'status' => 100,
				];

				$nId = $model -> insert($newData);
				
				echo '{"ok":1,"nId":"'.$nId.'"}';
			}

		}
	}

	public function save($users_id){

		if ($this->request->getMethod() == 'post') {
			// Validation;
			$rules = [
				'name' => 'required|min_length[3]',
				'email' => 'required|valid_email',

			];

			$errors = [
				'name' => [
					'required' => 'El nombre es obligatorio',
					'min_length' => 'El nombre debe contener al menos 3 caracteres',
				],
				'email' => [
					'required' => 'El correo electrónico es obligatorio',
					'valid_email' => 'Correo electrónico inválido',
					'is_unique' => 'El correo electrónico ya existe en la base de datos',
				],
			];

			// print2($_POST);
			if(!$this->validate($rules,$errors)){
				$r = [];
				$r['ok'] = 2;
				$r['err'] = $this->validator->listErrors();

				return(atj($r));
			}else{


				// Store company un DB
				$model = new UsersModel();

				$checkEmail = $model 
				-> where('id !=',$users_id) 
				-> where('email',$this->request->getVar('email'))
				->findAll();

				if(count($checkEmail) > 0){
					$r['ok'] = 2;
					$r['err'] = '<div class="errors" role="alert"><ul><li>El correo electrónico ya existe en la base de datos</li></ul></div>';
					return atj($r);
				}


				$corporations_id = empty($this->request->getVar('corporations_id'))?null:$this->request->getVar('corporations_id');
				$newData = [
					'email' => $this->request->getVar('email'),
					'name' => $this->request->getVar('name'),
					'status' => $this->request->getVar('status'),
				];
				if(!empty($this->request->getVar('password'))){
					$password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
					$newData['password'] = $password;
				}

				// print2($newData);

				$nId = $model -> update($users_id,$newData);
				
				return '{"ok":1}';

				// Store user un DB
				

			}

		}
	}

	public function list(){
		
		if ($this->request->getMethod() == 'post') {
			$model = new UsersModel();

			$text = $this->request->getVar('text');

			$list = $model 
				-> select('Users.*')
				-> like('Users.username', $text)
				-> orLike('Users.name', $text)
				-> orderBy('Users.name', 'ASC')
				-> findAll();

			$data = [];
			$data['list'] = $list;
				
			// echo "AAA";
			echo view('Administration/users/usersList.php',$data);

		}
	}

	public function searchUsers(){
		$data = [];
		echo view('Administration/users/searchUsers',$data);
	}


	//--------------------------------------------------------------------

	public function test(){
		$companiesModel = new UsersModel();
		$test = $companiesModel -> checkUsers('test.csv');

		print2($test);
	}

}



