<?php
namespace App\Controllers\Administration;
use App\Models\Administration\UsersModel;
use App\Models\Empresas\CompaniesModel;
use App\Models\Empresas\ContactsModel;
use App\Models\General\EstadosModel;
use App\Libraries\Email;


use App\Controllers\BaseController;
include_once APPPATH.'/ThirdParty/j/j.func.php';

class Companies extends BaseController{

	public function index(){

	    $data['title'] = 'Empresas';
	    $data['content'] = 'Administration/companies/index';

	    echo view('layout/base',$data);
	}

	public function addForm(){
		// echo '$type';
		$data = [];

		$estados_model = new EstadosModel();
		helper(['form']);
		$data['estados'] = $estados_model -> findAll();
		// print2($data['estados']);

		echo view('Administration/companies/addForm',$data);
	}

	public function edtForm($companies_id){
		$data = [];

		$estados_model = new EstadosModel();

		helper(['form']);
		$data['estados'] = $estados_model -> findAll();

		$model = new CompaniesModel();

		$data['company'] = $model ->where('id',$companies_id)->first();
		$data['companies_id'] = $companies_id;

		// print2($data['company']);

		echo view('Administration/companies/edtForm',$data);
	}

	public function add(){


		if ($this->request->getMethod() == 'post') {
			// Validation;
			$rules = [
				'name' => 'required|min_length[3]',
				'type' => 'required',
				'rfc' => 'required|min_length[12]|max_length[13]|is_unique[Companies.rfc]|RFC',
				// 'username' => 'required|min_length[3]|max_length[50]|is_unique[Companies.username]',
				'password' => 'required|min_length[9]',
				'email' => 'required|valid_email',

			];

			$errors = [
				'name' => [
					'required' => 'El nombre es obligatorio',
					'min_length' => 'El nombre debe contener al menos 3 caracteres',
				],
				'rfc' => [
					'required' => 'El RFC es obligatorio',
					'min_length' => 'El RFC debe tener al menos 12 caracteres',
					'max_length' => 'El RFC debe tener a lo más 13 caracteres',
					'is_unique' => 'El RFC ya existe en la base de datos',
					'RFC' => 'El RFC no tiene la estructura adecuada',
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
					// 'is_unique' => 'El correo electrónico ya existe en la base de datos',
				],
				'type' => [
					'required' => 'El tipo es obligatorio',
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
				$model = new CompaniesModel();

				$password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);

				$email = new Email();
				$subject = "Se ha creado un nuevo usuario en la Plataforma Transporte Limpio";
				$message = "Se ha creado un usuario para la empresa: ".$this->request->getVar('name')."<br/>" ;
				$message .= "Usuario: ".$this->request->getVar('rfc')."<br/>" ;
				$message .= "Contraseña: ".$this->request->getVar('password')."<br/>" ;
				$to[] = $this->request->getVar('email');
				$to[] = "transporte.limpio@semarnat.gob.mx";

				$email -> send($subject, $message, $to ,true);


				$corporations_id = empty($this->request->getVar('corporations_id'))?null:$this->request->getVar('corporations_id');
				$newData = [
					'username' => $this->request->getVar('username'),
					'password' => $password,
					'email' => $this->request->getVar('email'),
					'type' => $this->request->getVar('type'),
					'name' => $this->request->getVar('name'),
					'rfc' => $this->request->getVar('rfc'),
					'website' => $this->request->getVar('website'),
					'direccion' => $this->request->getVar('direccion'),
					'estado' => $this->request->getVar('estado'),
					'municipio' => $this->request->getVar('municipio'),
					'status' => 1,
					'cp' => $this->request->getVar('cp'),
				];

				$nId = $model -> insert($newData);
				
				echo '{"ok":1,"nId":"'.$nId.'"}';
			}

		}
	}

	public function save($companies_id){

		if ($this->request->getMethod() == 'post') {
			// Validation;
			$rules = [
				'name' => 'required|min_length[3]',
				'rfc' => 'required|min_length[12]|max_length[13]|RFC',
				'email' => 'required|valid_email',

			];

			$errors = [
				'name' => [
					'required' => 'El nombre es obligatorio',
					'min_length' => 'El nombre debe contener al menos 3 caracteres',
				],
				'rfc' => [
					'required' => 'El RFC es obligatorio',
					'min_length' => 'El RFC debe tener al menos 12 caracteres',
					'max_length' => 'El RFC debe tener a lo más 13 caracteres',
					'is_unique' => 'El RFC ya existe en la base de datos',
					'RFC' => 'El RFC no tiene la estructura adecuada',
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
				'type' => [
					'required' => 'El tipo es obligatorio',
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
				$model = new CompaniesModel();

				$checkRFC = $model 
				-> where('id !=',$companies_id) 
				-> where('rfc',$this->request->getVar('rfc'))
				->findAll();

				if(count($checkRFC) > 0){
					$r['ok'] = 2;
					$r['err'] = '<div class="errors" role="alert"><ul><li>El RFC ya existe en la base de datos</li></ul></div>';
					return atj($r);
				}

				// $checkEmail = $model 
				// -> where('id !=',$companies_id) 
				// -> where('email',$this->request->getVar('email'))
				// ->findAll();

				// if(count($checkEmail) > 0){
				// 	$r['ok'] = 2;
				// 	$r['err'] = '<div class="errors" role="alert"><ul><li>El correo electrónico ya existe en la base de datos</li></ul></div>';
				// 	return atj($r);
				// }


				$corporations_id = empty($this->request->getVar('corporations_id'))?null:$this->request->getVar('corporations_id');
				$newData = [
					'email' => $this->request->getVar('email'),
					'name' => $this->request->getVar('name'),
					'rfc' => $this->request->getVar('rfc'),
					'website' => $this->request->getVar('website'),
					'direccion' => $this->request->getVar('direccion'),
					'estado' => $this->request->getVar('estado'),
					'municipio' => $this->request->getVar('municipio'),
					'cp' => $this->request->getVar('cp'),
					'status' => $this->request->getVar('status'),
				];
				if(!empty($this->request->getVar('password'))){
					$password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
					$newData['password'] = $password;

					$email = new Email();
					$subject = "Se ha editado la información del usuario en la Plataforma Transporte Limpio";
					$message = "Se ha editado la información de la empresa: ".$this->request->getVar('name')."<br/>" ;
					$message .= "Usuario: ".$this->request->getVar('rfc')."<br/>" ;
					$message .= "Contraseña: ".$this->request->getVar('password')."<br/>" ;
					$to[] = $this->request->getVar('email');
					$to[] = "transporte.limpio@semarnat.gob.mx";

					$email -> send($subject, $message, $to ,true);

				}

				$nId = $model -> update($companies_id,$newData);
				
				return '{"ok":1}';

				// Store user un DB
				

			}

		}
	}

	public function list(){
		
		if ($this->request->getMethod() == 'post') {
			$model = new CompaniesModel();

			$text = $this->request->getVar('text');

			$list = $model 
				-> select('Companies.*,e.nombre as estadoNombre')
				-> join('Estados e','e.id = Companies.estado','left')
				->groupStart()
					-> like('Companies.name', $text)
					-> orLike('Companies.rfc', $text)
					-> orLike('Companies.direccion', $text)
				->groupEnd()
				-> where('type != ',3)
				-> orderBy('Companies.name', 'ASC')
				-> findAll();

			$data = [];
			$data['list'] = $list;
				
			echo view('Administration/companies/companiesList.php',$data);

		}
	}

	public function searchCompanies(){
		$data = [];
		echo view('Administration/companies/searchCompanies',$data);
	}

	public function viewContacts($companies_id){
		$contactsModel = new ContactsModel();
		$contacts = $contactsModel -> where('companies_id',$companies_id) -> findAll();
		$data['contacts'] = $contacts;
		echo view('Administration/companies/viewContacts',$data);
	}

	public function dwlCopanies(){
		$model = new CompaniesModel();

		$list = $model 
			-> select('Companies.*,e.nombre as estadoNombre, m.nombre as municipioNombre')
			-> join('Estados e','e.id = Companies.estado','left')
			-> join('Municipios m','m.id = Companies.municipio','left')
			-> where('type != ',3)
			-> orderBy('Companies.name', 'ASC')
			-> findAll();

		$data = [];
		$data['list'] = $list;
			
		echo view('Administration/companies/dwlList.php',$data);
	}

	public function pwdGenerator(){
		helper('text');
	    $pwd = random_string('alnum',9);

	    echo '{"pwd":"'.$pwd.'"}';
	}

	//--------------------------------------------------------------------

	public function test(){
		$companiesModel = new CompaniesModel();
		$test = $companiesModel -> checkCompanies('test.csv');

		print2($test);
	}

}



