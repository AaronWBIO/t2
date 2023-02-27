<?php

namespace App\Controllers\Administration;
use App\Models\Administration\UsersModel;
use App\Models\Administration\PwdRecoveryModel;
use App\Libraries\Email;

use App\Controllers\BaseController;
include_once APPPATH.'/ThirdParty/j/j.func.php';

class Login extends BaseController{

    public function index(){
    	$data['content'] = 'Administration/login/login';
    	$data['type'] = 'tr';

    	$redirect = '/administration/dashboard';
    	$isLoggedIn = session()->get('isLoggedInAdmin');

        if($isLoggedIn == 1){
            return redirect()->to($redirect);
        }
        


    	helper(['form']);
    	$model = new UsersModel();

    	if ($this->request->getMethod() == 'post') {
    		// Validation;

    		$rules = [
    			'username' => 'required',
    			'password' => 'required|validateInternalUser[username,pwd]',
    		];

    		$errors = [
    			'password' => [
    				'required' => 'Debes escribir una contraseña',
    				'validateuser' => 'Nombre de usuario o contraseña incorrectos',
    				// 'min_length' => TR('pwdMin'),
    				// 'max_length' => TR('pwdMax'),
    				// 'countAttempts' => TR('errAttempts'),
    				// 'userStatus' => TR('noAccess'),
    			],
    			'username' => [
    				'required' => 'Debes ingresar un nombre de usuario',
    				// 'min_length' => TR('emailMin'),
    				// 'max_length' => TR('emailMax'),
    				// 'valid_email' => TR('emailValid'),
    				// 'is_unique' => TR('emailExists'),
    			]

    		];

    		if(!$this->validate($rules,$errors)){
    			$data['validation'] = $this->validator;
    			// print2($data);
    			// echo $this->request->getVar('username');
    			// echo $this->request->getVar('password');
    			// exit("aaa");
    		}else{

    			// exit('aaaa');


    			$model = new UsersModel();
    			// $user = $model->where('email',$this->request->getVar('email'))->first();
    			$company = $model 
    			-> where ('username',$this->request->getVar('username'))
    			-> first();

    			$this->setUserSession($company);

    			return redirect()->to($redirect);

    		}

    	}

    	echo view('layout/base',$data);
    }

    protected function setUserSession($user){

    	// print2($user);
    	// exit();

    	$data = [
    		'id' => $user['id'],
    		'companies_id' => $user['id'],
    		'email' => $user['email'],
    		'isLoggedInAdmin' => true,
    	];

        $logged = session()->get('isLoggedIn');
        $loggedAdmin = session()->get('isLoggedInAdmin');

        if($logged || $loggedAdmin){
            session()->destroy();
        }

        session() -> set($data);
    	

    	return true;
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('/');
    }

    public function forgotPwd(){
        $data = [];

        helper(['form']);


        if ($this->request->getMethod() == 'post') {
            // Validation;
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
            ];

            $errors = [
                'pwd' => [
                    'required' => TR('pwdReq'),
                    'min_length' => TR('pwdMin'),
                    'max_length' => TR('pwdMax'),
                    'validateuser' => TR('notValidUser'),
                    'countAttempts' => TR('errAttempts'),
                    'userStatus' => TR('noAccess'),
                ],
                'email' => [
                    'required' => TR('emailReq'),
                    'min_length' => TR('emailMin'),
                    'max_length' => TR('emailMax'),
                    'valid_email' => TR('emailValid'),
                    'is_unique' => TR('emailExists'),
                ]

            ];


            if(!$this->validate($rules,$errors)){
                $data['validation'] = $this->validator;
            }

        }

        $data['content'] = 'Administration/login/forgotPwd';
        echo view('layout/base',$data);
    }

    public function emailRec(){
        
        if ($this->request->getMethod() == 'post') {
            // Validation;
            $rules = [
                'username' => 'required',
            ];

            $errors = [
                'username' => [
                    'required' => 'El nombre de usuario de usuario es obligatorio',
                ],
            ];

            if(!$this->validate($rules,$errors)){
                $data['validation'] = $this->validator;
                // print2($data['validation']);
                echo $this->validator->listErrors();

            }else{
                $ok = true;
                $model = new UsersModel();
                $user = $model
                -> where('username',$this->request->getVar('username'))
                -> first();

                if(empty($user)){
                    $ok = false;
                }


                if($ok){
                    $encrypter = \Config\Services::encrypter();

                    $today = date('Y-m-d H:i:s');
                    $hash = hash('sha256',"rec_$today",false);
                    $idhash = hash('sha256',"Id_$user[id]",false);

                    // echo  "Id_$user[id]";
                    $encryption = bin2hex($encrypter->encrypt($hash));

                    $pwdRecoveryModel = new PwdRecoveryModel();
                    // exit();

                    $newData = [
                        'elem_id' => $user['id'],
                        'hash' => $hash,
                        'timestamp' => $today,
                        'type' => 2,
                    ];
                    $pwdRecoveryModel -> insert($newData);


                    $url = base_url()."/Administration/Login/passwordRecovery/$encryption/$idhash";
                    // echo($url);

                    $data['content'] = "pwdRecEmail";
                    $data['url'] = $url;
                    $mail = view('general/email',$data);
                    $subject = 'Recuperación de contraseña';
                    $to = $user['email'];
                    // print2($user);

                    $email = new Email();
                    $email -> send($subject,$mail,[$to],false);

                    echo '{"ok":1}';
                    // $origin_id = $encrypter->decrypt( hex2bin($encryption) );

                }else{
                    echo '{"ok":0}';
                }
            }

        }
    }

    public function passwordRecovery($encryption=null,$idhash=null){
        $encrypter = \Config\Services::encrypter();
        // echo $encryption;
        // exit();
        $hash = $encrypter->decrypt( hex2bin($encryption) );
        // $hash = $encrypter->decrypt(hex2bin($encryption));
        // $encryption = bin2hex($encrypter->encrypt($hash));
        $pwdRecoveryModel = new PwdRecoveryModel();
        $pwdRecovery = $pwdRecoveryModel 
            -> where('hash',$hash) 
            -> where('used',null) 
            -> where('type',2) 
            -> first();

        // print2($pwdRecovery);
        // echo $idhash."\n<br/>";
        // echo hash('sha256', "Id_$pwdRecovery[elem_id]",false);


        if(empty($pwdRecovery)){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // echo "aaa";
        // exit();
        // $diff = dateDifference($pwdRecovery['timestamp'] , date('Y-m-d H:i:s') ,'%i' );
        $diff = abs(strtotime($pwdRecovery['timestamp']) - strtotime(date('Y-m-d H:i:s')))/60;
        // echo $diff;
        if($diff > 2880){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // exit();
        if( hash('sha256', "Id_$pwdRecovery[elem_id]",false) != $idhash ){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(); 
        }
        // exit();

        $data['encryption'] = $encryption;
        $data['idhash'] = $idhash;

        $data['content'] = 'Administration/login/newPwdRec';
        echo view('layout/base',$data);
    }

    public function chNewPassword($encryption=null,$idhash=null){
        $encrypter = \Config\Services::encrypter();
        // echo $encryption;
        $hash = $encrypter->decrypt( hex2bin($encryption) );
        // $hash = $encrypter->decrypt(hex2bin($encryption));
        // $encryption = bin2hex($encrypter->encrypt($hash));
        $pwdRecoveryModel = new PwdRecoveryModel();
        $pwdRecovery = $pwdRecoveryModel 
            -> where('hash',$hash) 
            -> where('used',null) 
            -> first();

        // print2($pwdRecovery);
        // echo $hash;

        if(empty($pwdRecovery)){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // $diff = dateDifference($pwdRecovery['timestamp'] , date('Y-m-d H:i:s') ,'%i' );
        $diff = abs(strtotime($pwdRecovery['timestamp']) - strtotime(date('Y-m-d H:i:s')))/60;

        if($diff > 1800){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if( hash('sha256', "Id_$pwdRecovery[elem_id]",false) != $idhash ){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(); 
        }

        if ($this->request->getMethod() == 'post') {
            // Validation;
            $rules = [
                'pwd' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[pwd]',
            ];

            $errors = [
                'password_confirm' => [
                    'matches' => TR('pwdNoMatch')
                ],
                'pwd' => [
                    'required' => TR('pwdReq'),
                    'min_length' => TR('pwdMin'),
                    'max_length' => TR('pwdMax'),
                ],
            ];

            // echo 'FAID: '.$this->request->getVar('facilities_id');

            if(!$this->validate($rules,$errors)){
                $r = [];
                $r['ok'] = 2;
                $r['err'] = $this->validator->listErrors();

                return(atj($r));
            }else{
                // Store user un DB
                $model = new UsersModel();
                
                $user = $model -> where('id',$pwdRecovery['elem_id']) ->first();

                $newData = [
                    'password' => password_hash($this->request->getVar('pwd'), PASSWORD_DEFAULT),
                    // 'attempts' => 0,
                    // 'status' => $user['status'] == 30 ? 100 : $user['status'],
                ];


                $nId = $model -> update($pwdRecovery['elem_id'],$newData);
                $pwdRecoveryModel -> update($pwdRecovery['id'],['used'=>1]);
                
                echo '{"ok":1,"nId":"'.$nId.'"}';

            }

        }
    }


}


