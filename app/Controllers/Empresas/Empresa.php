<?php

namespace App\Controllers\Empresas;

use App\Controllers\BaseController;
use App\Libraries\Calculations;
use App\Libraries\Results;
use App\Libraries\Validations;
use App\Libraries\Email;
use App\Models\Administration\CacheModel;
use App\Models\Administration\CategoriesModel;
use App\Models\Administration\UsersModel;
use App\Models\Empresas\Fleet_Fuels_Vclass_Quantity;
use App\Models\Empresas\FleetsArrayModel;
use App\Models\Administration\FuelsModel;
use App\Models\Administration\VclassModel;
use App\Models\Empresas\BrandsFleetsModel;
use App\Models\Empresas\BrandsModel;
use App\Models\Empresas\Comments;
use App\Models\Empresas\CompaniesModel;
use App\Models\Empresas\ContactsModel;
use App\Models\Empresas\Fleet_Fuels_Vclass_Reduction;
use App\Models\Empresas\Fleets_Fuels_Vclass_Travels;
use App\Models\Empresas\Fleets_Fuels_Vclass;
use App\Models\Empresas\FleetsFuelsModel;
use App\Models\Empresas\Mo_diesel as moDiesel;
use App\Models\Empresas\FleetsModel;
use App\Models\General\EstadosModel;
use App\Models\General\MunicipiosModel;
use CodeIgniter\HTTP\Request;
use Exception;

include_once APPPATH . '/ThirdParty/j/j.func.php';

use function PHPSTORM_META\map;

class Empresa extends BaseController
{
  protected $helpers = ['url', 'form'];
  private $companyModel = null;
  private $estadosModel = null;
  private $municipiosModel = null;
  private $contactsModel = null;
  private $fleetsModel = null;
  private $fuelsModel = null;
  private $encrypter = null;
  private $company = null;

  public function __construct()
  {
    $this->db = \Config\Database::connect();
    $this->companyModel = new CompaniesModel();
    $this->estadosModel = new EstadosModel();
    $this->municipiosModel = new MunicipiosModel();
    $this->contactsModel = new ContactsModel();
    $this->fleetsModel = new FleetsModel();
    $this->fuelsModel = new FuelsModel();
    $this->encrypter = \Config\Services::encrypter();

    /*===========================================
    CARGAMOS INFORMACION EMPRESA ACTUAL
    ===========================================*/
    $this->company = $this->companyModel->find(session()->id);
  }

  /**
   * Funcion para mostrar pantalla Inicio 
   * Entidades: Empresas Usuarias, Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return view
   */
  public function inicio()
  {
    // exit();
    $company = $this->company;
    $data['company'] = $company;
    $data['formulario'] = 'general';
    $data['content'] = 'Empresas/inicio/contenedor';
    $data['active_menu'] = 'inicio';

    //Tipo 1 Empresas
    if (session()->get('type') == 1) {

      $flotas_de_company = $this->fleetsModel
        ->select('Fleets.*, Companies.name as companyName')
        ->join('Companies', 'Fleets.companies_id = Companies.id')
        ->where('measure_year', date('Y'))
        ->where('companies_id', session()->id)->findAll();

      foreach ($flotas_de_company as $key => $value) {
        //Agregamos el id encriptado
        $flotas_de_company[$key]['id_encrypt'] = $this->encriptar($value['id']);
      }

      $data['flotas_de_company'] = json_encode($flotas_de_company);

      $contactos = new ContactsModel();

      $data['company']['contactos'] = $contactos
        ->where('companies_id', session()->id)
        ->findAll();
    } else { //Tipo 2 Empresa
      $BrandModel = new BrandsModel();
      $brands = $BrandModel
      ->where('companies_id', $company['id'])
      ->where('measure_year', date('Y'))
      ->find();

      // print2($brands);

      foreach ($brands as $key => $value) {
        //Agregamos el id encriptado
        $brands[$key]['id_encrypt'] = $this->encriptar($value['id']);
      }

      $data['brands'] = json_encode($brands);
    }

    echo view('layout/base', $data);
  }

  public function resultados()
  {

    helper(['form']);

    $companiesModel = new CompaniesModel();
    $fleetsModel = new FleetsModel();
    $brandsModel = new BrandsModel();
    $cacheModel = new CacheModel();
    $categoriesModel = new CategoriesModel();

    if (session() -> get('type') == 1) {
  
      $data['fleetYears'] = $fleetsModel
        ->select('distinct(measure_year)')
        ->join('Companies c', 'c.id = Fleets.companies_id', 'left')
        ->where('Fleets.status >=', 200)
        ->where('c.id', session()->get('id'))
        ->findAll();
    }elseif(session() -> get('type') == 2){
      $data['fleetYears'] = $brandsModel
        ->select('distinct(measure_year)')
        ->join('Companies c', 'c.id = Brands.companies_id', 'left')
        ->where('Brands.status >=', 200)
        ->where('c.id', session()->get('id'))
        ->findAll();

    }



    $data['categories'] = [];

    $data['content'] = 'Empresas/inicio/contenedor';
    $data['formulario'] = 'resultados';
    $data['active_menu'] = 'inicio';

    echo view('layout/base', $data);
  }

  /**
   * Funcion para mostrar pantalla Información de Socios 
   * Entidades: Empresas Usuarias, Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return view
   */
  public function informacionDeSocios()
  {
    $company = $this->companyModel->find(session()->id);
    $estados = $this->estadosModel->findAll();

    $data['content'] = 'Empresas/informacionDeContacto/contenedor';
    $data['formulario'] = 'informacionDeSocios';
    $data['company'] = $company;
    $data['estados'] = $estados;
    $data['active_menu'] = 'inicio';

    $municipios = $this->municipiosModel->select('id, nombre')
      ->where('estados_id', $data['company']['estado'])
      ->findAll();
    $data['municipios'] = $municipios;

    return view('layout/base', $data);
  }

  /**
   * Funcion para guardar información de socios (Información general de la empresa)
   * Entidades: Empresas Usuarias, Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return Json
   */
  public function guardarInformacionDeSocios()
  {
    if ($this->request->getMethod() == 'post') {
      $rules = [
        'estado' => 'required',
        'municipio' => 'required|numeric',
        'direccion' => 'required',
        'cp' => 'required|permit_empty|numeric',
        'telefono' => 'required|permit_empty|numeric|exact_length[10]',
      ];

      $errors = [
        'estado' => [
          'required' => 'El campo estado es obligatorio.',
        ],
        'municipio' => [
          'required' => 'El campo municipio es obligatorio.',
          'numeric' => 'Por favor selecciona un municipio valido.',
        ],
        'direccion' => [
          'required' => 'El campo dirección es obligatorio.',
        ],
        'cp' => [
          'required' => 'El campo código postal es obligatorio.',
          'numeric' => 'El campo código postal solo deben ser números.',
        ],
        'telefono' => [
          'numeric' => 'El campo telefono solo deben ser números.',
          'exact_length' => 'El campo telefono debe tener 10 digitos.',
          'required' => 'El campo teléfono es obligatorio.',
        ],
      ];

      if (!$this->validate($rules, $errors)) {

        $errores = $this->validator->listErrors();

        $response = [
          "ok" => 2,
          "errores" => $errores
        ];

        echo json_encode($response);
      } else {

        $_POST['id'] = session()->id;
        $this->companyModel->save($_POST);
        session()->setFlashdata(
          'success',
          'Información guardada correctamente.'
        );

        $response = [
          "ok" => 1,
        ];

        echo json_encode($response);
      }
    }
  }

  /**
   * Funcion para mostrar pantalla Contactos 
   * Entidades: Empresas Usuarias, Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return view
   */
  public function contactos()
  {

    $contactos = json_encode($this->contactsModel->where('companies_id', session()->id)->find());

    $data['content'] = 'Empresas/informacionDeContacto/contenedor';
    $data['formulario'] = 'contactos';
    $data['contactos'] = $contactos;
    $data['active_menu'] = 'inicio';
    echo view('layout/base', $data);
  }

  /**
   * Funcion para mostrar pantalla Formulario de Contacto 
   * Nota: Esta pantalla es utilizada como modal
   * Entidades: Empresas Usuarias, Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return view
   */
  public function formularioContacto()
  {

    $data['accion'] = 'Agregar';

    if (!empty($_POST['accion']) && $_POST['accion'] == 'editar') {
      $data['accion'] = 'Editar';
      $data['contacto'] = $this->contactsModel->find($_POST['id']);
    }

    if (!empty($_POST['accion']) && $_POST['accion'] == 'eliminar') {
      $data['contacto'] = $this->contactsModel->find($_POST['id']);
      $data['accion'] = 'Eliminar';
      $data['eliminar'] = true;
    }

    $estados = $this->estadosModel->findAll();
    $data['estados'] = $estados;
    echo view('Empresas/informacionDeContacto/formularioContacto', $data);
  }

  /**
   * Funcion para eliminar un contacto
   * Entidades: Empresas Usuarias, Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return string
   */
  public function eliminarContacto()
  {
    $this->contactsModel->delete($_POST['id']);
    session()->setFlashdata(
      'success',
      'Información eliminada correctamente.'
    );

    echo "ok";
  }

  /**
   * Funcion para guardar Contacto
   * Entidades: Empresas Usuarias, Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return Json
   */
  public function guardarContacto()
  {

    $rules = [
      'type' => 'required|numeric',
      'position' => 'required',
      'email' => 'required|valid_email',
      'phone' => 'required|numeric|exact_length[10]',
      // 'ext' => 'required|numeric',
      'phone2' => 'permit_empty|numeric|exact_length[10]',
      'ext2' => 'permit_empty|numeric',
      'curp' => 'required',
      'nombre' => 'required|max_length[255]',
    ];

    $errors = [
      'email' => [
        'required' => 'El correo electrónico es obligatorio',
        'valid_email' => 'Correo electrónico inválido',
        'is_unique' => 'El correo electrónico ya existe en la base de datos',
      ],
      'type' => [
        'required' => 'El campo tipo es obligatorio.',
      ],
      'position' => [
        'required' => 'El campo cargo es obligatorio.',
      ],
      'email' => [
        'required' => 'El campo correo eléctronico es obligatorio.',
        'valid_email' => 'El correo electrónico debe ser un correo válido.',
      ],
      'phone' => [
        'required' => 'El campo teléfono es obligatorio.',
        'exact_length' => 'El campo telefono debe tener 10 digitos.',
        'numeric' => 'El campo telefono solo deben ser números.',
      ],
      'ext' => [
        'required' => 'El campo ext es obligatorio.',
        'numeric' => 'El campo ext solo deben ser números.',
      ],
      'phone2' => [
        'required' => 'El campo telefono 2 es obligatorio.',
        'exact_length' => 'El campo telefono 2 debe tener 10 digitos.',
        'numeric' => 'El campo telefono 2 solo deben ser números.',
      ],
      'ext2' => [
        'required' => 'El campo ext2 es obligatorio.',
        'numeric' => 'El campo ext2 solo deben ser números.',
      ],
      'curp' => [
        'required' => 'El campo CURP es obligatorio.',
      ],
      'nombre' => [
        'required' => 'El campo nombre es obligatorio.',
        'max_length' => 'El campo nombre no debe ser mayor a 255 caracteres.',
      ],
    ];

    if (!$this->validate($rules, $errors)) {
      $response = [
        'ok' => 2,
        'data' => $_POST,
        'err' => $this->validator->listErrors(),
      ];
      return json_encode($response);
    }

    $_POST['companies_id'] = session()->id;
    $this->contactsModel->save($_POST);
    session()->setFlashdata(
      'success',
      'Información guardada correctamente.'
    );

    echo '{"ok":1,"data":' . json_encode($_POST) . '}';
  }

  /**
   * Funcion para actualizar nombre de la empresa
   * Entidades: Empresas Usuarias, Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return Json
   */
  public function actualizarNombreEmpresa()
  {
    $rules = [
      'name' => 'required|max_length[255]',
    ];
    $errors = [
      'nombre' => [
        'required' => 'El campo nombre es obligatorio.',
        'max_length' => 'El campo nombre no debe ser mayor a 255 caracteres.',
      ],
    ];

    if (!$this->validate($rules, $errors)) {
      $response = [
        'ok' => 2,
        'data' => $_POST,
        'err' => $this->validator->listErrors(),
      ];
      return json_encode($response);
    }

    // $_POST['companies_id'] = session()->id;
    $this->companyModel->update(session()->id, $_POST);
    // session()->setFlashdata(
    //   'success',
    //   'Información guardada correctamente.'
    // );

    echo '{"ok":1,"data":' . json_encode($_POST) . '}';
  }

  /*::::::::::::::::::: F L O T A S :::::::::::::::::::*/

  /**
   * Funcion para mostrar pantalla Descripción Flotas
   * Entidades: Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return View
   */
  public function descripcionFlotas()
  {
    $company = $this->companyModel->find(session()->id);
    $fleets = $this->fleetsModel
    ->select('Fleets.*,Categories.name as categoria')
    ->join('Categories', 'Categories.id = Fleets.categories_id', 'left')
    ->where('companies_id', session()->id)
    ->where('measure_year', date('Y'))
    ->find();

    $data['active_menu'] = 'inicio';
    $data['fleets'] = $fleets;
    $data['company'] = $company;
    $data['content'] = 'Empresas/flotas/flotas';
    echo view('layout/base', $data);
  }

  /**
   * Funcion para crear o actualizar flotas
   * Entidades: Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return Json
   */
  public function guardarDescripcionFlotas()
  {
    if ($this->request->getMethod() == "post") {

      /*=====================================
      CARGAMOS MODELOS A UTILIZAR
      =====================================*/

      $validations = new Validations();

      /*=====================================
      DEPENDE LA DATA DE LA PETICION, EJECUTAMOS ACCION
      DATA = ELIMINADOS: ELIMINAMOS TODAS LAS FLOTAS 
      DATA = ARRAY: CREAMOS O ACTUALIZAMOS FLOTA
      =====================================*/

      if (isset($_POST['eliminados'])) {
        /*=====================================
        ELIMINAMOS FLOTA
        =====================================*/

        foreach ($_POST['eliminados'] as $key => $fleet_id) {

          $fleet = $this->fleetsModel->find($fleet_id);

          /*=====================================
          VALIDAR STATUS DE FLOTAS
          =====================================*/

          if ($fleet['status'] >= 100) {
            continue;
          }

          $this->fleetsModel->delete($fleet_id);
        }
      } else {
        /*=====================================
        CREAMOS O ACTUALIZAMOS FLOTAS
        =====================================*/

        foreach ($_POST as $key => $value) {

          /*=====================================
          VALIDAMOS FLOTA
          =====================================*/

          if (intval($value['total_operacion']) != 100) {
            $response = [
              "ok" => 2,
              "errores" => 'Flota: ' . $value['name'] . '. El porcentaje total de operación debe ser igual a 100'
            ];
            echo json_encode($response);
            die();
          }

          if (intval($value['total_carroceria']) != 100) {
            $response = [
              "ok" => 2,
              "errores" => 'Flota: ' . $value['name'] . '. El porcentaje total de tipo de carrocería debe ser igual a 100'
            ];
            echo json_encode($response);
            die();
          }

          $value['companies_id'] = session()->id;
          $value['measure_year'] = date("Y");

          /*=====================================
          VALIDAR STATUS DE FLOTAS
          =====================================*/

          if (isset($value['id']) && $f = $this->fleetsModel->find($value['id'])) {
            if (intval($f['status']) >= 100) {
              continue;
            }
          }

          /*=====================================
          ASIGNAR STATUS A FLOTA, NÚMERO 1 RECIEN CREADA
          =====================================*/
          if(!isset($value['id'])){
            $value['status'] = 1;
          }

          /*=====================================
          CREAR O ACTUALIZAR FLOTA
          =====================================*/
          // print2($value); //name
          $this->fleetsModel->save($value);
        }

        /*=====================================
        ASIGNAMOS CATEGORIA A LAS FLOTAS
        =====================================*/
        $fleets = $this
        ->fleetsModel
        -> where('companies_id',session()->id)
        ->findAll();

        foreach ($fleets as $key => $value) {
          $value['categories_id'] = $validations->category($value['id'])['id'];
          // echo "companies_id: ".$value['companies_id']."\n";
          // echo "fleets_id: ".$value['id']."\n";
          $this->fleetsModel->save($value);
          $response_validaciones_flota = $validations->fleetEval($value['id']);
        }
      }
      // if(isset($value['id'])){
      //   $validations = new Validations();
        
      //   print2('aaaa');
      // }

      session()->setFlashdata(
        'success',
        'Información guardada correctamente.'
      );

      $response = [
        "ok" => 1,
      ];

      echo json_encode($response);
    }
  }

  /**
   * Funcion para mostrar pantalla Flotas Información General
   * Entidades: Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return View
   */
  public function flotasInformacionGeneral()
  {
    /*=====================================
    VALIDAMOS SI LA FLOTA EXISTE Y PERTENECE A USUARIO ACTUAL
    =====================================*/
    $fleet = $this->validarSiExisteFlotaYQuePertenceAlUsuarioActual();
    if (!$fleet) {
      return redirect()->to('/Empresas/empresa/inicio');
    }

    $data['fleet'] = $fleet;
    $data['fuels'] = $this->fuelsModel->where('id !=', 8)->find();

    $data['fleet']['fuels'] = $this->fleetsModel->fuels($fleet['id']);

    if ($data['fleet']['fuels'] != []) {
      foreach ($data['fleet']['fuels'] as $key => $value) {
        $data['fleet']['fuels'][$key]->id_encriptado = $this->encriptar($value->id);
      }
    }

    $data['content'] = 'Empresas/flotas/informacionGeneral';
    $data['main_menu'] = 'flotas';
    $data['active_menu'] = 'informacionGeneral';
    echo view('layout/base', $data);
  }

  /**
   * Funcion guardar informacion de la flota
   * Entidades: Empresas
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return Json
   */
  public function guardarFlotasInformacionGeneral()
  {

    // exit("AAAA");
    if ($this->request->getMethod() == 'post') {

      //Validar aqui
      $fleet = $this->validarSiExisteFlotaYQuePertenceAlUsuarioActual();

      /*=====================================
      VALIDAR STATUS DE FLOTAS
      =====================================*/

      if (!$fleet || intval($fleet['status']) >= 100) {
        $response = [
          "ok" => 3,
          "errores" => "Ha ocurrido un error."
        ];
        return json_encode($response);
      }

      /*=====================================
      CREAMOS REGLAS DE VALIDACION
      =====================================*/

      $rules = [
        'usa' => 'required|numeric',
        'canada' => 'required|numeric',
        'mexico' => 'required|numeric|fleetsOperationsPercentage[usa,canada,mexico]',
        'intermediary' => 'required|numeric',
        'intermediaryPercent' => 'required|numeric|less_than[5.1]|greater_than[0]',
        'large' => 'required|numeric|less_than[101]|greater_than[-1]',
        'short' => 'required|numeric|less_than[101]|greater_than[-1]|fleetsRecorrido[short,large]',
        'fuels' => 'required',
      ];

      if (isset($_POST['intermediary']) && $_POST['intermediary'] == 0) {
        unset($rules['intermediaryPercent']);
      }

      if (isset($_POST['large']) && isset($_POST['short'])) {
        if ($_POST['large'] == "" && $_POST['short'] == "100") {
          $rules['large'] = "permit_empty|numeric";
        }
        if ($_POST['short'] == "" && $_POST['large'] == "100") {
          $rules['short'] = "permit_empty|numeric";
        }
      }

      $errors = [
        'usa' => [
          'required' => 'El campo EE.UU es obligatorio.',
          'numeric' => 'El campo EE.UU solo deben ser números.',
        ],
        'canada' => [
          'required' => 'El campo Canadá es obligatorio.',
          'numeric' => 'El campo Canadá solo deben ser números.',
        ],
        'mexico' => [
          'required' => 'El campo México es obligatorio.',
          'numeric' => 'El campo México solo deben ser números.',
          'fleetsOperationsPercentage' => 'La suma de los porcentajes debe ser igual a 100'
        ],
        'intermediary' => [
          'required' => 'Por favor indique si cedío a un intermediario.',
          'numeric' => 'El campo intermediario solo deben ser números.',
        ],
        'intermediaryPercent' => [
          'required' => 'El campo Porcentaje de Intermediario es obligatorio.',
          'numeric' => 'El campo Porcentaje de Intermediario solo deben ser números.',
          'greater_than' => 'El campo Porcentaje de Intermediario debe ser mayor a 0%.',
          'less_than' => 'Usted indico que subcontrata más del 5% del volumen total transportado por su empresa. Para eficientar la operación de su flota debe tener el control de al menos el 95% de su flota; considérelo para futuros reportes en la plataforma y marque la casilla NO en ¿Cedió a un intermediario una parte del volumen total transportado por su empresa?.',
        ],
        'large' => [
          'required' => 'El campo Recorrido Largo es obligatorio.',
          'numeric' => 'El campo Recorrido Largo solo deben ser números.',
          'greater_than' => 'El campo Recorrido Largo debe ser mayor a 0%.',
          'less_than' => 'El campo Recorrido Largo no puede ser mayor a 100%.',
        ],
        'short' => [
          'required' => 'El campo Recorrido Corto es obligatorio.',
          'numeric' => 'El campo Recorrido Corto solo deben ser números.',
          'greater_than' => 'El campo Recorrido Corto debe ser mayor a 0%.',
          'less_than' => 'El campo Recorrido Corto no puede ser mayor a 100%.',
          'fleetsRecorrido' => 'La suma de los recorridos debe ser igual a 100%',
        ],
        'fuels' => [
          'required' => 'Debe seleccionar al menos un combustible.',
        ]
      ];

      /*=====================================
      VALIDAMOS LA DATA 
      =====================================*/

      if (!$this->validate($rules, $errors)) {
        $response = [
          'ok' => 2,
          'errores' => $this->validator->listErrors(),
        ];
        return json_encode($response);
      } else {

        //Actualziamos información de la flota
        $this->fleetsModel->update($fleet['id'], $_POST);

        //Obtenemos los combustibles seleccionados por el cliente
        $_fuels_selected = isset($_POST['fuels']) ? $_POST['fuels'] : [];

        //Cargamos modelo de combustibles
        $Fleets_FuelsModel = new FleetsFuelsModel();

        $Fleets_FuelsModel->where('fleets_id', $fleet['id'])->set(['active' => 0])->update();

        foreach ($_fuels_selected as $key => $value) {
          //Verificamos si el combustible selccionado existe
          $a = $Fleets_FuelsModel->where('fleets_id', $fleet['id'])->where('fuels_id', $value)->first();
          if ($a) {
            $Fleets_FuelsModel->save([
              'id' => $a['id'],
              'fleets_id' => $fleet['id'],
              'fuels_id' => $value,
              'active' => 1
            ]);
          } else {
            $Fleets_FuelsModel->save([
              'fleets_id' => $fleet['id'],
              'fuels_id' => $value,
              'active' => 1
            ]);
          }
        }
        $validations = new Validations();
        $response_validaciones_flota = $validations->fleetEval($fleet['id']);

        session()->setFlashdata(
          'success',
          'Información guardada correctamente.'
        );

        $response = [
          "ok" => 1,
        ];

        echo json_encode($response);
      }
    }
  }

  public function flotasCombustibles()
  {

    //Validar aqui
    $fleet = $this->validarSiExisteFlotaYQuePertenceAlUsuarioActual();
    $_Fleet_Fuel = $this->validarFlotaCombustibleActivo();
    if (!$fleet || !$_Fleet_Fuel) {
      return redirect()->to('/Empresas/empresa/inicio');
    }

    $data['fleet'] = $fleet;

    $data['fleet']['fuels'] = $this->fleetsModel->fuels($_Fleet_Fuel['fleets_id']);
    foreach ($data['fleet']['fuels'] as $key => $value) {
      $data['fleet']['fuels'][$key]->id_encriptado = $this->encriptar($value->id);
    }

    $VclassModel = new VclassModel();
    $fleetsModel = new FleetsModel();
    $fuelsModel = new FuelsModel();
    $Fleets_Fuels_Vclass_QuantityModel = new Fleet_Fuels_Vclass_Quantity();
    $Fleets_Fuels_Vclass_TravelModel = new Fleets_Fuels_Vclass_Travels();
    $Fleets_Fuels_Vclass_ReductionModel = new Fleet_Fuels_Vclass_Reduction();

    $fleets_fuels_vclass_quantity_data = $Fleets_Fuels_Vclass_QuantityModel
      ->where('fleets_fuels_id', $_Fleet_Fuel['id'])
      ->find();

    $Fleets_Fuels_Vclass_Travel_data = $Fleets_Fuels_Vclass_TravelModel
      ->where('fleets_fuels_id', $_Fleet_Fuel['id'])
      ->find();

    $Fleets_Fuels_Vclass_Reduction_data = $Fleets_Fuels_Vclass_ReductionModel
      ->where('fleets_fuels_id', $_Fleet_Fuel['id'])
      ->find();

    $data['Fleets_Fuels_Vclass_Reduction_data']  = $Fleets_Fuels_Vclass_Reduction_data;
    $data['Fleets_Fuels_Vclass_Travel_data']  = $Fleets_Fuels_Vclass_Travel_data;
    $data['fleets_fuels_vclass_quantity_data'] = $fleets_fuels_vclass_quantity_data;
    $data['vClasses'] = $VclassModel->findAll();
    $data['clases_seleccionadas'] = empty($fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id'])) ? [] : $fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id']);
    $data['content'] = 'Empresas/flotas/combustibles/combustible';
    $data['formulario'] = 'combustible';
    $data['combustible_seleccionado'] = $fuelsModel->find($_Fleet_Fuel['fuels_id']);
    $data['pantallas_de_flotas'] = true;
    echo view('layout/base', $data);
  } //V1

  public function traerFleets_Fuels_Vclass_Travel_data()
  {
    $Fleets_FuelsModel = new FleetsFuelsModel();
    $fleet_fuel = $Fleets_FuelsModel->find($this->desencriptar($_POST['ff']));
    $Fleets_Fuels_Vclass_TravelModel = new Fleets_Fuels_Vclass_Travels();
    $Fleets_Fuels_Vclass_Travel_data = $Fleets_Fuels_Vclass_TravelModel
      ->where('fleets_fuels_id', $fleet_fuel['id'])
      ->find();
    echo json_encode($Fleets_Fuels_Vclass_Travel_data);
  }

  public function traerFleets_Fuels_Vclass_Reduction_data()
  {
    $Fleets_FuelsModel = new FleetsFuelsModel();
    $fleet_fuel = $Fleets_FuelsModel->find($this->desencriptar($_POST['ff']));
    $Fleets_Fuels_Vclass_ReductionModel = new Fleet_Fuels_Vclass_Reduction();
    $Fleets_Fuels_Vclass_Reduction_data = $Fleets_Fuels_Vclass_ReductionModel
      ->where('fleets_fuels_id', $fleet_fuel['id'])
      ->find();
    echo json_encode($Fleets_Fuels_Vclass_Reduction_data);
  }

  /**
   * Funcion para ver pantalla en donde se agregan clases a un combustible | clases  
   * Entidades: Empresas 
   *  
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function flotasCombustibleClases()
  {

    /*=====================================
    CARGAMOS MODELOS A UTILIZAR
    =====================================*/
    $VclassModel = new VclassModel();
    $fleetsModel = new FleetsModel();
    $fuelsModel = new FuelsModel();

    /*=====================================
    VALIDAMOS INFORMACIÓN PARA PDER ACCEDER AL CONTROLADOR
    =====================================*/

    $fleet = $this->validarSiExisteFlotaYQuePertenceAlUsuarioActual();
    $_Fleet_Fuel = $this->validarFlotaCombustibleActivo();
    if (!$fleet || !$_Fleet_Fuel) {
      return redirect()->to('/Empresas/empresa/inicio');
    }

    //Cargamos la flota
    $data['fleet'] = $fleet;

    //Cargamos combustibles de la flota
    $data['fleet']['fuels'] = $this->fleetsModel->fuels($_Fleet_Fuel['fleets_id']);
    foreach ($data['fleet']['fuels'] as $key => $value) {
      $data['fleet']['fuels'][$key]->id_encriptado = $this->encriptar($value->id);
    }

    $data['clases_seleccionadas'] = empty($fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id'])) ? [] : $fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id']);
    $data['vClasses'] = $VclassModel->findAll();
    $data['content'] = 'Empresas/flotas/combustibles/contenedor';
    $data['formulario'] = 'clases';
    $data['main_menu'] = 'flotas';
    $data['active_menu'] = 'flotas';
    $data['combustible_seleccionado'] = $fuelsModel->find($_Fleet_Fuel['fuels_id']);
    echo view('layout/base', $data);
  }

  /**
   * Funcion para guardar clases relacionadas a un combustible   
   * Entidades: Empresas 
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return Json
   */
  public function guardarFlotasCombustibleClases()
  {
    if ($this->request->getMethod() == 'post') {

      /*=====================================
      CARGAMOS MODELOS A UTILIZAR
      =====================================*/

      $Fleets_FuelsModel = new FleetsFuelsModel();
      $Fleets_Fuels_VclassModel = new Fleets_Fuels_Vclass();

      /*=====================================
      CREAMOS RELACIONES Y GUARDAMOS INFORMACION EN LA TABALA Fleet_Fuels_Vclass
      =====================================*/

      $fleet_fuel = $Fleets_FuelsModel->find($this->desencriptar($_POST['ff']));

      try {
        if (isset($_POST['clases_eliminadas'])) {
          foreach ($_POST['clases_eliminadas'] as $key => $value) {
            $Fleets_Fuels_VclassModel->where('Fleets_Fuels_id', $fleet_fuel['id'])->where('vclass_id', $value)->delete();
          }
        }

        if (isset($_POST['clases_agregadas'])) {
          foreach ($_POST['clases_agregadas'] as $key => $value) {
            if (!$Fleets_Fuels_VclassModel->where('Fleets_Fuels_id', $fleet_fuel['id'])->where('vclass_id', $value)->first()) {
              $g = $Fleets_Fuels_VclassModel->save([
                'Fleets_Fuels_id' => $fleet_fuel['id'],
                'vclass_id' => $value,
              ]);
            }
          }
        }

        $response = [
          'ok' => 1,
          'mensaje' => 'Información guardada correctamente.'
        ];

        session()->setFlashdata(
          'success',
          'Información guardada correctamente.'
        );
      } catch (Exception $e) {
        $response = [
          'ok' => 5,
          'errores' => 'Ha ocurrido un error, porfavor intenta más tarde. Si el problema persiste ponte en contacto con un administrador.'
        ];
      }

      return json_encode($response);
    }
  }

  /**
   * Funcion para ver pantalla en donde se ingresan los datos de Año modelo y motor | quantity
   * Entidades: Empresas 
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function flotasCombustibleQuantity()
  {
    /*=====================================
    CARGAMOS MODELOS A UTILIZAR
    =====================================*/
    $VclassModel = new VclassModel();
    $fleetsModel = new FleetsModel();
    $fuelsModel = new FuelsModel();
    $Fleets_Fuels_Vclass_QuantityModel = new Fleet_Fuels_Vclass_Quantity();

    /*=====================================
    VALIDAMOS INFORMACIÓN PARA PDER ACCEDER AL CONTROLADOR
    =====================================*/

    $fleet = $this->validarSiExisteFlotaYQuePertenceAlUsuarioActual();
    $_Fleet_Fuel = $this->validarFlotaCombustibleActivo();
    if (!$fleet || !$_Fleet_Fuel) {
      return redirect()->to('/Empresas/empresa/inicio');
    }

    //Cargamos la flota
    $data['fleet'] = $fleet;

    //Cargamos combustibles de la flota
    $data['fleet']['fuels'] = $this->fleetsModel->fuels($_Fleet_Fuel['fleets_id']);
    foreach ($data['fleet']['fuels'] as $key => $value) {
      $data['fleet']['fuels'][$key]->id_encriptado = $this->encriptar($value->id);
    }

    $fleets_fuels_vclass_quantity_data = $Fleets_Fuels_Vclass_QuantityModel
      ->where('fleets_fuels_id', $_Fleet_Fuel['id'])
      ->find();

    $data['fleets_fuels_vclass_quantity_data'] = $fleets_fuels_vclass_quantity_data;
    $data['clases_seleccionadas'] = empty($fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id'])) ? [] : $fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id']);
    $data['vClasses'] = $VclassModel->findAll();
    $data['content'] = 'Empresas/flotas/combustibles/contenedor';
    $data['formulario'] = 'quantity';
    $data['main_menu'] = 'flotas';
    $data['active_menu'] = 'flotas';
    $data['combustible_seleccionado'] = $fuelsModel->find($_Fleet_Fuel['fuels_id']);
    echo view('layout/base', $data);
  }

  /**
   * Funcion para guardar informacion en tabla quantity   
   * Entidades: Empresas 
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   */
  public function guardarFlotasCombustibleQuantity()
  {
    if ($this->request->getMethod() == 'post') {

      /*=====================================
      CARGAMOS MODELOS A UTILIZAR
      =====================================*/

      $Fleets_FuelsModel = new FleetsFuelsModel();

      /*=====================================
      DESENCRIPTAMOS ID Y OBTENEMOS VALORES
      =====================================*/

      $fleet_fuel = $Fleets_FuelsModel->find($this->desencriptar($_POST['ff']));
      $fleet = $this->fleetsModel->find($fleet_fuel['fleets_id']);

      /*=====================================
      INICIO: VALIDAR STATUS DE FLOTAS
      =====================================*/
      if (intval($fleet['status']) >= 100) {
        $response = [
          "ok" => 3,
          "errores" => "Ha ocurrido un error."
        ];
        return json_encode($response);
      }
      /*=====================================
      FIN: VALIDAR STATUS DE FLOTAS
      =====================================*/

      /*=====================================
      CREAMOS RELACIONES Y GUARDAMOS INFORMACION EN LA TABALA Fleet_Fuels_Vclass
      =====================================*/

      $Fleets_Fuels_VclassModel = new Fleets_Fuels_Vclass();

      if (isset($_POST['euros5'])) {
        foreach ($_POST['euros5'] as $key => $value) {
          $Fleets_Fuels_VclassModel
            ->where('Fleets_Fuels_id', $fleet_fuel['id'])
            ->where('vclass_id', $value['vclass_id'])
            ->set($value)
            ->update();
        }
      }

      if (isset($_POST['euros6'])) {
        foreach ($_POST['euros6'] as $key => $value) {
          $Fleets_Fuels_VclassModel
            ->where('Fleets_Fuels_id', $fleet_fuel['id'])
            ->where('vclass_id', $value['vclass_id'])
            ->set($value)
            ->update();
        }
      }

      if (isset($_POST['clases_eliminadas'])) {
        foreach ($_POST['clases_eliminadas'] as $key => $value) {
          $Fleets_Fuels_VclassModel->where('Fleets_Fuels_id', $fleet_fuel['id'])->where('vclass_id', $value)->delete();
        }
      }

      if (isset($_POST['clases_agregadas'])) {
        foreach ($_POST['clases_agregadas'] as $key => $value) {
          if (!$Fleets_Fuels_VclassModel->where('Fleets_Fuels_id', $fleet_fuel['id'])->where('vclass_id', $value)->first()) {
            $g = $Fleets_Fuels_VclassModel->save([
              'Fleets_Fuels_id' => $fleet_fuel['id'],
              'vclass_id' => $value,
            ]);
          }
        }
      }

      /*=====================================
      GUARDAR INFORMACION EN TABLA Fleet_Fuels_VClass_Quantity
      =====================================*/

      $Fleets_Fuels_Vclass_QuantityModel = new Fleet_Fuels_Vclass_Quantity();

      if (isset($_POST['data'])) {
        foreach ($_POST['data'] as $key => $value) {
          if (!$Fleets_Fuels_Vclass_QuantityModel
            ->where('Fleets_Fuels_id', $fleet_fuel['id'])
            ->where('vclass_id', $value['classid'])
            ->where('year', $value['year'])
            ->first()) {

            $data['fleets_fuels_id'] = $fleet_fuel['id'];
            $data['vclass_id'] = $value['classid'];
            $data['year'] = $value['year'];

            if (isset($value['quantity'])) {
              $data['quantity'] = $value['quantity'];
            }
            if (isset($value['euro5'])) {
              $data['euro5'] = $value['euro5'];
            }
            if (isset($value['euro6'])) {
              $data['euro6'] = $value['euro6'];
            }

            $Fleets_Fuels_Vclass_QuantityModel->save($data);
          } else {

            if (isset($value['quantity'])) {
              $data['quantity'] = $value['quantity'];
            }
            if (isset($value['euro5'])) {
              $data['euro5'] = $value['euro5'];
            }
            if (isset($value['euro6'])) {
              $data['euro6'] = $value['euro6'];
            }

            $Fleets_Fuels_Vclass_QuantityModel
              ->where('Fleets_Fuels_id', $fleet_fuel['id'])
              ->where('vclass_id', $value['classid'])
              ->where('year', $value['year'])
              ->set($data)
              ->update();
          }

          $data = [];
        }
      }

      $validations = new Validations();
      $response_validaciones_flota = $validations->fleetEval($fleet_fuel['fleets_id']);


      session()->setFlashdata(
        'success',
        'Información guardada correctamente.'
      );

      echo '{"ok":1,"mensaje":"Información guardada correctamente"}';
    }
  }

  public function flotasGuardarInformacionCombustibles()
  {
    if ($this->request->getMethod() == 'post') {

      /*=====================================
      DESENCRIPTAMOS ID Y OBTENEMOS VALORES
      =====================================*/

      $Fleets_FuelsModel = new FleetsFuelsModel();
      $fleet_fuel = $Fleets_FuelsModel->find($this->desencriptar($_POST['ff']));

      $fleet = $this->fleetsModel->find($fleet_fuel['fleets_id']);
      /*=====================================
      INICIO: VALIDAR STATUS DE FLOTAS
      =====================================*/
      if (intval($fleet['status']) >= 100) {
        $response = [
          "ok" => 3,
          "errores" => "Ha ocurrido un error."
        ];
        return json_encode($response);
      }
      /*=====================================
      FIN: VALIDAR STATUS DE FLOTAS
      =====================================*/

      /*=====================================
      CREAMOS RELACIONES Y GUARDAMOS INFORMACION EN LA TABALA Fleet_Fuels_Vclass
      =====================================*/

      $Fleets_Fuels_VclassModel = new Fleets_Fuels_Vclass();

      if (isset($_POST['clases_eliminadas'])) {
        foreach ($_POST['clases_eliminadas'] as $key => $value) {
          $Fleets_Fuels_VclassModel->where('Fleets_Fuels_id', $fleet_fuel['id'])->where('vclass_id', $value)->delete();
        }
      }

      if (isset($_POST['clases_agregadas'])) {
        foreach ($_POST['clases_agregadas'] as $key => $value) {
          if (!$Fleets_Fuels_VclassModel->where('Fleets_Fuels_id', $fleet_fuel['id'])->where('vclass_id', $value)->first()) {
            $g = $Fleets_Fuels_VclassModel->save([
              'Fleets_Fuels_id' => $fleet_fuel['id'],
              'vclass_id' => $value,
            ]);
          }
        }
      }

      /*=====================================
      GUARDAR INFORMACION EN TABLA Fleet_Fuels_VClass_Quantity
      =====================================*/

      $Fleets_Fuels_Vclass_QuantityModel = new Fleet_Fuels_Vclass_Quantity();

      if (isset($_POST['data'])) {
        foreach ($_POST['data'] as $key => $value) {
          if (!$Fleets_Fuels_Vclass_QuantityModel
            ->where('Fleets_Fuels_id', $fleet_fuel['id'])
            ->where('vclass_id', $value['classid'])
            ->where('year', $value['year'])
            ->first()) {

            $data['fleets_fuels_id'] = $fleet_fuel['id'];
            $data['vclass_id'] = $value['classid'];
            $data['year'] = $value['year'];

            if (isset($value['quantity'])) {
              $data['quantity'] = $value['quantity'];
            }
            if (isset($value['euro5'])) {
              $data['euro5'] = $value['euro5'];
            }
            if (isset($value['euro6'])) {
              $data['euro6'] = $value['euro6'];
            }

            $Fleets_Fuels_Vclass_QuantityModel->save($data);
          } else {

            if (isset($value['quantity'])) {
              $data['quantity'] = $value['quantity'];
            }
            if (isset($value['euro5'])) {
              $data['euro5'] = $value['euro5'];
            }
            if (isset($value['euro6'])) {
              $data['euro6'] = $value['euro6'];
            }

            $Fleets_Fuels_Vclass_QuantityModel
              ->where('Fleets_Fuels_id', $fleet_fuel['id'])
              ->where('vclass_id', $value['classid'])
              ->where('year', $value['year'])
              ->set($data)
              ->update();
          }

          $data = [];
        }
      }

      echo '{"ok":1,"mensaje":"Información guardada correctamente"}';
    }
  }

  /**
   * Funcion para ver pantalla en donde se ingresan los datos de Información de actividad | travels
   * Entidades: Empresas 
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function flotasCombustiblesTravels()
  {
    /*=====================================
    CARGAMOS MODELOS A UTILIZAR
    =====================================*/
    $VclassModel = new VclassModel();
    $fleetsModel = new FleetsModel();
    $fuelsModel = new FuelsModel();
    $Fleets_Fuels_Vclass_TravelModel = new Fleets_Fuels_Vclass_Travels();

    /*=====================================
    VALIDAMOS INFORMACIÓN PARA PDER ACCEDER AL CONTROLADOR
    =====================================*/

    $fleet = $this->validarSiExisteFlotaYQuePertenceAlUsuarioActual();
    $_Fleet_Fuel = $this->validarFlotaCombustibleActivo();
    if (!$fleet || !$_Fleet_Fuel) {
      return redirect()->to('/Empresas/empresa/inicio');
    }

    //Cargamos la flota
    $data['fleet'] = $fleet;

    //Cargamos combustibles de la flota
    $data['fleet']['fuels'] = $this->fleetsModel->fuels($_Fleet_Fuel['fleets_id']);
    foreach ($data['fleet']['fuels'] as $key => $value) {
      $data['fleet']['fuels'][$key]->id_encriptado = $this->encriptar($value->id);
    }

    $Fleets_Fuels_Vclass_Travel_data = $Fleets_Fuels_Vclass_TravelModel
      ->where('fleets_fuels_id', $_Fleet_Fuel['id'])
      ->find();

    $data['Fleets_Fuels_Vclass_Travel_data']  = $Fleets_Fuels_Vclass_Travel_data;
    $data['clases_seleccionadas'] = empty($fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id'])) ? [] : $fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id']);
    $data['vClasses'] = $VclassModel->findAll();
    $data['content'] = 'Empresas/flotas/combustibles/contenedor';
    $data['formulario'] = 'travels';
    $data['main_menu'] = 'flotas';
    $data['active_menu'] = 'flotas';
    $data['combustible_seleccionado'] = $fuelsModel->find($_Fleet_Fuel['fuels_id']);
    echo view('layout/base', $data);
  }

  /**
   * Funcion para guardar informacion en tabla travels   
   * Entidades: Empresas 
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   */
  public function guardarFlotasCombustiblesTravels()
  {
    // exit('aa');
    if ($this->request->getMethod() == 'post') {

      /*=====================================
      CARGAMOS MODELOS A UTILIZAR
      =====================================*/
      $VclassModel = new VclassModel();
      $Fleets_FuelsModel = new FleetsFuelsModel();
      $Fleets_Fuels_VclassModel = new Fleets_Fuels_Vclass();
      $Fleets_Fuels_Vclass_TravelModel = new Fleets_Fuels_Vclass_Travels();
      $Fleets_Fuels_Vclass_TravelsModel = new Fleets_Fuels_Vclass_Travels();
      $validations = new Validations();
      $commentsModel = new Comments();

      /*=====================================      
      DESENCRIPTAMOS ID Y OBTENEMOS VALORES
      =====================================*/

      $fleet_fuel = $Fleets_FuelsModel->find($this->desencriptar($_POST['ff']));

      $fleet = $this->fleetsModel->find($fleet_fuel['fleets_id']);

      $fuel = $this->fuelsModel->find($fleet_fuel['fuels_id']);

      /*=====================================
      INICIO: VALIDAR STATUS DE FLOTAS
      =====================================*/
      if (intval($fleet['status']) >= 100) {
        $response = [
          "ok" => 3,
          "errores" => "Ha ocurrido un error."
        ];
        return json_encode($response);
      }
      /*=====================================
      FIN: VALIDAR STATUS DE FLOTAS
      =====================================*/

      /*=====================================
      CREAMOS RELACIONES Y GUARDAMOS INFORMACION EN LA TABALA Fleet_Fuels_Vclass
      =====================================*/

      if (isset($_POST['clases_eliminadas'])) {
        foreach ($_POST['clases_eliminadas'] as $key => $value) {
          $Fleets_Fuels_VclassModel->where('Fleets_Fuels_id', $fleet_fuel['id'])->where('vclass_id', $value)->delete();
        }
      }

      if (isset($_POST['clases_agregadas'])) {
        foreach ($_POST['clases_agregadas'] as $key => $value) {
          if (!$Fleets_Fuels_VclassModel->where('Fleets_Fuels_id', $fleet_fuel['id'])->where('vclass_id', $value)->first()) {
            $g = $Fleets_Fuels_VclassModel->save([
              'Fleets_Fuels_id' => $fleet_fuel['id'],
              'vclass_id' => $value,
            ]);
          }
        }
      }

      /*=====================================
      GUARDAMOS TRAVELS EN TABLAA Fleets_Fuels_Vclass_Travels
      =====================================*/

      $post_data = [];
      if (isset($_POST['data'])) {
        foreach ($_POST['data'] as $key => $value) {
          $k = explode('#', $key);
          $post_data[$k[0]][$k[1]] = $value;
        }

        $rules = [
          'vclass_id' => [
            'required',
            'numeric',
          ],
          'lts_tot' => [
            'required' => ['Porfavor ingresa los litros utilizados'],
            'numeric' => ['El campo litros utilizados debe ser numérico'],
          ],
          'payload_avg' => [
            'required' => ['Porfavor ingresa la carga útil promedio'],
            'numeric' => ['El campo carga útil promedio debe ser numérico'],
            'percentage' => ['El campo carga útil promedio debe ser entre 0 y 100']
          ],
          'km_tot' => [
            // 'required' => ['Porfavor ingresa los kilómetros recorridos totales'],
            'numeric' => ['El campo kilómetros recorridos totales debe ser numérico'],
          ],
          // 'km_empty' => [
          //   // 'required' => ['Porfavor ingresa los kilómetros recorridos vacios'],
          //   'numeric' => ['El campo kilómetros recorridos en vacío no tiene valor, deja un comentario'],
          // ],
          'highway' => [
            // 'required' => ['Porfavor ingresa los Autopista o carretera '],
            'numeric' => ['El campo Autopista o carretera debe ser numérico'],
            'percentage' => ['El campo Autopista o carretera debe ser entre 0 y 100']
          ],
          'less_40' => [
            // 'required' => ['Porfavor ingresa los Menos de 40 km/h'],
            'numeric' => ['El campo Menos de 40 km/h debe ser numérico'],
            'percentage' => ['El campo Menos de 40 km/h debe ser entre 0 y 100']
          ],
          '40_80' => [
            // 'required' => ['Porfavor ingresa los 40 a 80 km/h'],
            'numeric' => ['El campo 40 a 80 km/h debe ser numérico'],
            'percentage' => ['El campo 40 a 80 km/h debe ser entre 0 y 100']
          ],
          'over_80' => [
            // 'required' => ['Porfavor ingresa los Más de 80 km/h'],
            'numeric' => ['El campo Más de 80 km/h debe ser numérico'],
            'percentage' => ['El campo Más de 80 km/h debe ser entre 0 y 100']
          ],
          'ralenti_hours_large' => [
            // 'required' => ['Porfavor ingresa los Horas en ralentí de duración larga al día por camión'],
            // 'numeric' => ['El campo Horas en ralentí de duración larga al día por camión debe ser numérico'],
            'percentage' => ['El campo Horas en ralentí de duración larga al día por camión debe ser entre 0 y 24']
          ],
          'ralenti_hours_short' => [
            'required' => ['Porfavor ingresa los kHoras en ralentí de duración corta al día por camión'],
            'numeric' => ['El campo Horas en ralentí de duración corta al día por camión debe ser numérico'],
            'percentage' => ['El campo Horas en ralentí de duración corta al día por camión debe ser entre 0 y 24']
          ],
          'ralenti_days' => [
            'required' => ['Porfavor ingresa los Número promedio de días en carretera al año'],
            'numeric' => ['El campo Número promedio de días en carretera al año debe ser numérico'],
            'percentage' => ['El campo Número promedio de días en carretera al año debe ser entre 0 y 365']
          ],
        ];

        $errores = [];

        foreach ($post_data as $key => $travel) {
          $vclass = $VclassModel->find($travel['vclass_id']);

          if ($fleet_fuel['fuels_id'] == '7') {
            $errores[$vclass['name']]['hybrid_type'] = "Por favor especifique el tipo de combustible";
          }

          if(empty($travel['km_empty'])){
            $comment = $commentsModel 
            -> where('fleets_fuels_id',$fleet_fuel['id'])
            -> where('field','km_empty')
            -> where('vclass_id',$vclass['id'])
            -> first();

            
            if(empty($comment)){
              $errores[$vclass['name']]['km_empty'] = 'El campo kilómetros recorridos en vacío no tiene valor, deja un comentario';
            }else{
              if(empty($comment['comment'])){
                $errores[$vclass['name']]['km_empty'] = 'El campo kilómetros recorridos en vacío no tiene valor, deja un comentario';
              }
            }
          }

          if(empty($travel['km_empty'])){
            $comment = $commentsModel 
            -> where('fleets_fuels_id',$fleet_fuel['id'])
            -> where('field','km_empty')
            -> where('vclass_id',$vclass['id'])
            -> first();

            
            if(empty($comment)){
              $errores[$vclass['name']]['km_empty'] = 'El campo kilómetros recorridos en vacío no tiene valor, deja un comentario';
            }else{
              if(empty($comment['comment'])){
                $errores[$vclass['name']]['km_empty'] = 'El campo kilómetros recorridos en vacío no tiene valor, deja un comentario';
              }
            }
          }
          // print2([$fleet_fuel['id'],$vclass,$travel]);


          //Calculando la suma de % de velocidad

          $travel['highway'] = $travel['highway'] == '' ? 0 : $travel['highway'];
          $travel['less_40'] = $travel['less_40'] == '' ? 0 : $travel['less_40'];
          $travel['40_80'] = $travel['40_80'] == '' ? 0 : $travel['40_80'];
          $travel['over_80'] = $travel['over_80'] == '' ? 0 : $travel['over_80'];

          $suma_velocidad =
            $travel['highway'] +
            $travel['less_40'] +
            $travel['40_80'] +
            $travel['over_80'];

          if ($suma_velocidad != 100) {
            $errores[$vclass['name']]['suma_velocidades'] = "La suma de los % de velocidad debe ser 100";
          }

          foreach ($rules as $rule_field => $rule_values) {
            if (array_key_exists($rule_field, $travel)) {
              foreach ($rule_values as $rule => $rule_value) {
                if (is_array($rule_value)) {
                  switch ($rule) {
                    case 'required':
                      if (empty($travel[$rule_field])) {
                        $errores[$vclass['name']][$rule_field] = $rule_value[0];
                      }
                      break;
                    case 'numeric':
                      if (!is_numeric($travel[$rule_field])) {
                        $errores[$vclass['name']][$rule_field] = $rule_value[0];
                      }
                      break;
                    case 'percentage':
                      if (is_numeric($travel[$rule_field]) && (intval($travel[$rule_field]) < 0 || intval($travel[$rule_field]) > 365)) {
                        $errores[$vclass['name']][$rule_field] = $rule_value[0];
                      }
                      break;
                  }
                } else {
                  switch ($rule) {
                    case 'required':
                      if (empty($travel[$rule_field])) {
                        $errores[$vclass['name']][$rule_field] = "El campo $rule_field es requerido";
                      }
                      break;
                    case 'numeric':
                      if (!is_numeric($travel[$rule_field])) {
                        $errores[$vclass['name']][$rule_field] = "El campo $rule_field debe ser números";
                      }
                      break;
                    case 'percentage':
                      if (is_numeric($travel[$rule_field]) && (intval($travel[$rule_field]) < 0 || intval($travel[$rule_field]) > 101)) {
                        $errores[$vclass['name']][$rule_field] = "El campo $rule_field debe ser entre 0 y 100";
                      }
                      break;
                  }
                }
              }
            } else {
              $errores[$vclass['name']][$rule_field] = "El campo $rule_field es requerido";
            }
          }
        }

        $lista_errores = "<ul>";

        foreach ($errores as $clase => $mensajes) {
          foreach ($mensajes as $field_name => $field_mensaje) {
            $lista_errores .= "<li>$clase: $field_mensaje</li>";
          }
        }

        $lista_errores .= "</ul>";

        if ($errores) {
          $response['errores'] = $lista_errores;
        }

        /*========================1=============
        GUARDAMOS TRAVELS EN TABLAA Fleets_Fuels_Vclass_Travels
        =====================================*/

        foreach ($post_data as $key => $value) {
          if (!$Fleets_Fuels_Vclass_TravelsModel
            ->where('fleets_fuels_id', $fleet_fuel['id'])
            ->where('vclass_id', $value['vclass_id'])
            ->first()) {

            $value['fleets_fuels_id'] = $fleet_fuel['id'];

            $Fleets_Fuels_Vclass_TravelsModel->save($value);
          } else {
            foreach ($value as $key => $v) {
              
              if(empty($v) && ($v != '0')){
                // print2([$key,$v]);
                $value[$key] = null;
              }
            }

            // print2($value);
            $Fleets_Fuels_Vclass_TravelsModel
              ->where('Fleets_Fuels_id', $fleet_fuel['id'])
              ->where('vclass_id', $value['vclass_id'])
              ->set($value)
              ->update();
          }

          $data = [];
        }

        /*=====================================
        VALIDAMOS FLOTA COMPLETA
        =====================================*/

        $response_validaciones_flota = $validations->fleetEval($fleet_fuel['fleets_id']);

        /*=====================================
        CONVERTIMOS LOS VALORES RETORNADOS DE VALIDACION A NOTACION TIPO INPUT NAME
        Descripcion: Esto facilitara en Javascript la busqueda de los elementos erroneos en la matriz de inputs
        =====================================*/

        $inputsNames = [];

        $current_fuel_response_validation = $response_validaciones_flota[$fuel['name']];

        foreach ($current_fuel_response_validation as $class_name => $fields) {
          $current_class = $VclassModel->where('name', $class_name)->first();
          foreach ($fields as $field_name => $status) {

            if ($field_name == 'ralenti') {
              $inputsNames[] = [
                'name' => $current_class['id'] . '#ralenti_hours_large',
                'status' => $status,
                'vclass_id' => $current_class['id'],
                'field' => 'ralenti_hours_large',
                'fleets_fuels_id' => $fleet_fuel['id'],
                'color' => $status
              ];
              $inputsNames[] = [
                'name' => $current_class['id'] . '#ralenti_hours_short',
                'status' => $status,
                'vclass_id' => $current_class['id'],
                'field' => 'ralenti_hours_short',
                'fleets_fuels_id' => $fleet_fuel['id'],
                'color' => $status
              ];
            } else if ($field_name == 'km/l') {
              $inputsNames[] = [
                'name' => $current_class['id'] . '#lts_tot',
                'status' => $status,
                'vclass_id' => $current_class['id'],
                'field' => 'lts_tot',
                'fleets_fuels_id' => $fleet_fuel['id'],
                'color' => $status
              ];
            } else {
              $inputsNames[] = [
                'name' => $current_class['id'] . '#' . $field_name,
                'status' => $status,
                'vclass_id' => $current_class['id'],
                'field' => $field_name,
                'fleets_fuels_id' => $fleet_fuel['id'],
                'color' => $status
              ];
            }
          }
        }

        $response['validacion'] = $inputsNames;
      }

      $response['ok'] = 1;
      $response['mensaje'] = "Información guardada correctamente";

      return json_encode($response);
    }
  }

  /**
   * Funcion mostrar modal de agregar comentario | Travels
   * Entidades: Empresas 
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   */
  public function travelClassFuelComentario()
  {
    /*=====================================
    CARGAMOS MODELOS A UTILIZAR
    =====================================*/
    $CommentsModel = new Comments();

    /*=====================================
    BUSCAMOS SI YA HAY UN COMENTARIO EXISTENTE
    =====================================*/

    $comment = $CommentsModel
      ->where('fleets_fuels_id', $_POST['fleets_fuels_id'])
      ->where('field', $_POST['field'])
      ->where('color', $_POST['color'])
      ->where('vclass_id', $_POST['vclass_id'])
      ->first();

    if ($comment) {
      $data['data'] = $comment;
    } else {
      $data['data'] = $_POST;
    }

    echo view('Empresas/flotas/combustibles/travel_class_fuel_comentario', $data);
  }

  /**
   * Funcion para guardar comentarios en resultados con status mayor a 0 | Travels
   * Entidades: Empresas 
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   */
  public function guardarTravelClassFuelComentario()
  {
    if ($this->request->getMethod() == 'post') {
      /*=====================================
      CARGAMOS MODELOS A UTILIZAR
      =====================================*/
      $CommentsModel = new Comments();

      /*=====================================
      GUARDAMOS COMENTARIO
      =====================================*/
      $CommentsModel->save($_POST);

      $response = [
        'ok' => 1,
        'success' => 'Comentario enviado',
      ];

      return json_encode($response);
    }
  }

  /**
   * Funcion para ver pantalla en donde se ingresan los datos de reducción de pm | reduction
   * Entidades: Empresas 
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function flotasCombustiblesReduction()
  {
    /*=====================================
    CARGAMOS MODELOS A UTILIZAR
    =====================================*/
    $VclassModel = new VclassModel();
    $fleetsModel = new FleetsModel();
    $fuelsModel = new FuelsModel();
    $Fleets_Fuels_Vclass_ReductionModel = new Fleet_Fuels_Vclass_Reduction();
    $Fleet_Fuels_Vclass_Quantity = new Fleet_Fuels_Vclass_Quantity();

    /*=====================================
    VALIDAMOS INFORMACIÓN PARA PDER ACCEDER AL CONTROLADOR
    =====================================*/

    $fleet = $this->validarSiExisteFlotaYQuePertenceAlUsuarioActual();
    $_Fleet_Fuel = $this->validarFlotaCombustibleActivo();
    if (!$fleet || !$_Fleet_Fuel) {
      return redirect()->to('/Empresas/empresa/inicio');
    }

    //Cargamos la flota
    $data['fleet'] = $fleet;

    //Cargamos combustibles de la flota
    $data['fleet']['fuels'] = $this->fleetsModel->fuels($_Fleet_Fuel['fleets_id']);
    foreach ($data['fleet']['fuels'] as $key => $value) {
      $data['fleet']['fuels'][$key]->id_encriptado = $this->encriptar($value->id);
    }

    $Fleets_Fuels_Vclass_Reduction_data = $Fleets_Fuels_Vclass_ReductionModel
      ->where('fleets_fuels_id', $_Fleet_Fuel['id'])
      ->find();

    $Fleet_Fuels_Vclass_Quantity_data = $Fleet_Fuels_Vclass_Quantity
      ->where('fleets_fuels_id', $_Fleet_Fuel['id'])
      ->find();

    $quantities = array();
    foreach ($Fleet_Fuels_Vclass_Quantity_data as $q) {
      $quantities[$q['vclass_id']][$q['year']] = $q['quantity'];
    }

    $data['Fleets_Fuels_Vclass_Reduction_data']  = $Fleets_Fuels_Vclass_Reduction_data;
    $data['quantities']  = $quantities;
    $data['clases_seleccionadas'] = empty($fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id'])) ? [] : $fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id']);
    $data['vClasses'] = $VclassModel->findAll();
    $data['content'] = 'Empresas/flotas/combustibles/contenedor';
    $data['formulario'] = 'reduction';
    $data['main_menu'] = 'flotas';
    $data['active_menu'] = 'flotas';
    $data['combustible_seleccionado'] = $fuelsModel->find($_Fleet_Fuel['fuels_id']);
    echo view('layout/base', $data);
  }

  /**
   * Funcion para guardar informacion en tabla reduction   
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   */
  public function guardarFlotasCombustiblesReduction()
  {
    if ($this->request->getMethod() == 'post') {

      /*=====================================
      CARGAMOS MODELOS A UTILIZAR
      =====================================*/

      $Fleets_FuelsModel = new FleetsFuelsModel();

      /*=====================================
      DESENCRIPTAMOS ID Y OBTENEMOS VALORES
      =====================================*/

      $fleet_fuel = $Fleets_FuelsModel->find($this->desencriptar($_POST['ff']));
      $fleet = $this->fleetsModel->find($fleet_fuel['fleets_id']);

      /*=====================================
      INICIO: VALIDAR STATUS DE FLOTAS
      =====================================*/
      if (intval($fleet['status']) >= 100) {
        $response = [
          "ok" => 3,
          "errores" => "Ha ocurrido un error."
        ];
        return json_encode($response);
      }
      /*=====================================
      FIN: VALIDAR STATUS DE FLOTAS
      =====================================*/

      /*=====================================
      CREAMOS RELACIONES Y GUARDAMOS INFORMACION EN LA TABALA Fleet_Fuels_Vclass
      =====================================*/

      $Fleets_Fuels_VclassModel = new Fleets_Fuels_Vclass();

      if (isset($_POST['clases_eliminadas'])) {
        foreach ($_POST['clases_eliminadas'] as $key => $value) {
          $Fleets_Fuels_VclassModel->where('Fleets_Fuels_id', $fleet_fuel['id'])->where('vclass_id', $value)->delete();
        }
      }

      if (isset($_POST['clases_agregadas'])) {
        foreach ($_POST['clases_agregadas'] as $key => $value) {
          if (!$Fleets_Fuels_VclassModel->where('Fleets_Fuels_id', $fleet_fuel['id'])->where('vclass_id', $value)->first()) {
            $g = $Fleets_Fuels_VclassModel->save([
              'Fleets_Fuels_id' => $fleet_fuel['id'],
              'vclass_id' => $value,
            ]);
          }
        }
      }

      /*=====================================
      GUARDAMOS REDUCTION EN TABLA Fleets_Fuels_Vclass_Reduction
      =====================================*/

      $Fleets_Fuels_Vclass_ReductionModel = new Fleet_Fuels_Vclass_Reduction();

      if (isset($_POST['data'])) {
        foreach ($_POST['data'] as $key => $value) {
          if (!$Fleets_Fuels_Vclass_ReductionModel
            ->where('fleets_fuels_id', $fleet_fuel['id'])
            ->where('vclass_id', $value['classid'])
            ->where('year', $value['year'])
            ->first()) {

            $data['fleets_fuels_id'] = $fleet_fuel['id'];
            $data['vclass_id'] = $value['classid'];
            $data['year'] = $value['year'];
            $data['quantity'] = $value['quantity'];


            $Fleets_Fuels_Vclass_ReductionModel->save($data);
          } else {

            $data['quantity'] = $value['quantity'];

            $Fleets_Fuels_Vclass_ReductionModel
              ->where('Fleets_Fuels_id', $fleet_fuel['id'])
              ->where('vclass_id', $value['classid'])
              ->where('year', $value['year'])
              ->set($data)
              ->update();
          }

          $data = [];
        }
      }

      session()->setFlashdata(
        'success',
        'Información guardada correctamente.'
      );

      echo '{"ok":1,"mensaje":"Información guardada correctamente"}';
    }
  }

  /**
   * Funcion para mostrar pantalla Agregar Brands 
   * Entidades: Empresas Usuarias
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return view
   */
  public function agregarBrands()
  {

    $company = $this->companyModel->find(session()->id);

    $BrandModel = new BrandsModel();

    $data['brands'] = $BrandModel
    ->where('companies_id', $company['id'])
    ->where('measure_year', date('Y'))
    ->find();
    $data['company'] = $company;

    $data['content'] = 'Empresas/empresasUsuarias/agregarBrands';
    echo view('layout/base', $data);
  }

  /**
   * Funcion para guardar Brands
   * Entidades: Empresas Usuarias
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return Json
   */
  public function guardarBrands()
  {

    if ($this->validarRevYear()){
      $response = [
        'ok' => 2,
        'errores' => 'No se puede editar la información'
      ];
      return json_encode($response);
    }

    if ($this->request->getMethod() == "post") {

      /*=====================================
      CARGAMOS MODELOS A UTILIZAR
      =====================================*/

      $BrandModel = new BrandsModel();

      //Obtenemos el array data
      $post_data = [];
      if (isset($_POST['data'])) {
        foreach ($_POST['data'] as $key => $value) {
          $k = explode('#', $key);
          $post_data[$k[0]][$k[1]] = $value;
        }
      }

      /*=====================================
      VALIDAMOS DATOS
      =====================================*/

      $errores = [];

      foreach ($post_data as $key => $brand) {
        if (empty($brand['name'])) {
          $errores[] = 'El campo nombre es requerido';
        }
        // if (empty($brand['scian'])) {
        //   $errores[] = 'El campo scian es requerido';
        // }
      }

      $lista_errores = "<ul>";

      foreach ($errores as $mensaje) {
        $lista_errores .= "<li>$mensaje</li>";
      }

      $lista_errores .= "</ul>";

      if ($errores) {
        $response['ok'] = 2;
        $response['errores'] = $lista_errores;
        return json_encode($response);
      }

      /*=====================================
      ELIMINAMOS COMPAÑIAS
      =====================================*/
      // print2($_POST);
      if (isset($_POST['eliminados'])) {
        // print2($_POST['eliminados']);
        $BrandModel->whereIn('id',$_POST['eliminados'])->delete();
      }

      /*=====================================
      GUARDAMOS INFORMACIÓN
      =====================================*/

      // print2($post_data);


      foreach ($post_data as $key => $value) {
        $value['measure_year'] = date('Y');
        $value['companies_id'] = session()->id;
        if(!isset($value['id'])){
          $value['status'] = 4;
        }
        $BrandModel->save($value);
      }

      session()->setFlashdata(
        'success',
        'Información guardada correctamente.'
      );

      $response = [
        "ok" => 1,
      ];

      echo json_encode($response);
    }
  }

  /**
   * Funcion para mostrar pantalla Agregar Transportistas
   * Entidades: Empresas Usuarias
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return view
   */
  public function brandsAgregarTransportistas()
  {

    /*=====================================
    CARGAMOS MODELOS A UTILIZAR
    =====================================*/
    $BrandsFleetsModel = new BrandsFleetsModel();
    $BrandModel = new BrandsModel();

    $data['content'] = 'Empresas/empresasUsuarias/brands/agregarTransportistas';
    $data['company'] = $this->companyModel->find(session()->id);
    $data['company']['brand'] = $BrandModel
      ->where('companies_id', session()->id)
      ->where('id', $this->desencriptar($_GET['brand']))
      ->first();

    /*=====================================
    Compañias Smartway
    =====================================*/

    $fleets = $this->companyModel->select('Companies.name as company_name, Companies.direccion, Categories.name as categoria, Fleets.name, Fleets.id')
      ->join('Fleets', 'Fleets.companies_id = Companies.id')
      ->join('Categories', 'Categories.id = Fleets.categories_id')
      ->where('Companies.type', 1)
      ->where('Fleets.status >=', 200)
      ->where('Fleets.measure_year', date('Y'))
      ->find();

    $data['fleets'] = $fleets;

    $data['company']['brand']['fleets'] = $BrandsFleetsModel
      ->select('c.name as company_name, c.direccion, cat.name as categoria, f.name, f.id, Brands_Fleets.id as brands_fleets_id')
      ->join('Brands b', 'b.id = Brands_Fleets.brands_id', 'left')
      ->join('Fleets f', 'f.id = Brands_Fleets.fleets_id', 'left')
      ->join('Companies c', 'c.id = f.companies_id', 'left')
      ->join('Categories cat', 'cat.id = f.categories_id', 'left')
      ->where('Brands_Fleets.brands_id', $this->desencriptar($_GET['brand']))
      ->where('b.measure_year', date('Y'))
      ->where('c.type', 1)
      ->find();

    /*=====================================
    Compañias No-Smartway
    =====================================*/

    $no_sw_fleets = $this->companyModel->select('Companies.name as company_name, Companies.direccion, Categories.name as categoria, Fleets.name, Fleets.id')
      ->join('Fleets', 'Fleets.companies_id = Companies.id','left','left')
      ->join('Categories', 'Categories.id = Fleets.categories_id','left')
      ->where('Companies.type', 3)
      ->find();

    $data['no_sw_fleets'] = $no_sw_fleets;

    $data['company']['brand']['no_sw_fleets'] = $BrandsFleetsModel
      ->select('c.name as company_name, c.direccion, cat.name as categoria, f.name, f.id, Brands_Fleets.id as brands_fleets_id')
      ->join('Brands b', 'b.id = Brands_Fleets.brands_id', 'left')
      ->join('Fleets f', 'f.id = Brands_Fleets.fleets_id', 'left')
      ->join('Companies c', 'c.id = f.companies_id', 'left')
      ->join('Categories cat', 'cat.id = f.categories_id', 'left')
      ->where('Brands_Fleets.brands_id', $this->desencriptar($_GET['brand']))
      ->where('b.measure_year', date('Y'))
      ->where('c.type', 3)
      ->find();

      // print2($no_sw_fleets);

    $data['main_menu'] = "brand";
    $data['active_menu'] = "agregar_transportistas";
    echo view('layout/base', $data);
  }

  /**
   * Funcion para guardar los transportistas asignados a una Brand
   * Entidades: Empresas Usuarias
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return Json
   */
  public function brandsGuardarTransportistas()
  {

    /*=====================================
    CARGAMOS MODELOS A UTILIZAR
    =====================================*/

    $BrandsFleetsModel = new BrandsFleetsModel();
    $brandsModel = new BrandsModel();

    $brands = $brandsModel -> where('companies_id',session()->id) -> where('measure_year',date('Y')) -> findAll();

    // print2($brands);

    foreach ($brands as $br) {
      // code...
      $brandsFleets = $BrandsFleetsModel -> select('Brands_Fleets.*, b.name, b.companies_id')
      -> join('Brands b','b.id = Brands_Fleets.id','left')
      -> where('Brands_Fleets.brands_id',$br['id'])
      -> findAll();

      // echo session() -> id;
      // print2($brandsFleets);

      $status = true;
      foreach ($brandsFleets as $b) {
          switch ($b['measure_type']) {
              case '1':
                  if(empty($b['ton_km']) || empty($b['tot_km'])){
                      $status = false;
                      break 2;
                  }
                  break;
              case '2':
                  if(empty($b['ton_km']) || empty($b['avg_payload'])){
                      $status = false;
                      break 2;
                  }
                  break;
              case '3':
                  if(empty($b['tot_km']) || empty($b['avg_payload'])){
                      $status = false;
                      break 2;
                  }
                  break;
              case '4':
                  if(empty($b['tot_km'])){
                      $status = false;
                      break 2;
                  }
                  break;
              
              default:
                  // code...
                  break;
          }
      }

      if($status){
        $newData['status'] = 90;
      }else{
        $newData['status'] = 70;
      }

      // print2($br);
      if($br['status']<100){
        $brandsModel -> update($br['id'],$newData);
      }

    }



    if (isset($_POST['eliminadas'])) {
      foreach ($_POST['eliminadas'] as $key => $value) {
        if ($fleets = $BrandsFleetsModel
          ->where('brands_id', $value['brands_id'])
          ->where('fleets_id', $value['fleets_id'])
          ->first()
        ) {
          $BrandsFleetsModel->delete($fleets['id']);
        }
      }
    }

    if (isset($_POST['agregadas'])) {
      foreach ($_POST['agregadas'] as $key => $value) {
        if (!$BrandsFleetsModel
          ->where('brands_id', $value['brands_id'])
          ->where('fleets_id', $value['fleets_id'])
          ->first()) {
          $value['measure_year'] = date('Y');
          $BrandsFleetsModel->save($value);
        }
      }
    }

    $response['ok'] = 1;
    $response['mensaje'] = "Información guardada correctamente";

    return json_encode($response);
  }

  /**
   * Funcion para mostrar pantalla Guardar Datos de Actividad
   * Entidades: Empresas Usuarias
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return view
   */
  public function brandsDatosDeActividad()
  {

    /*=====================================
    CARGAMOS MODELOS A UTILIZAR
    =====================================*/
    $BrandsFleetsModel = new BrandsFleetsModel();
    $BrandModel = new BrandsModel();

    $data['content'] = 'Empresas/empresasUsuarias/brands/datosDeActividad';
    $data['company'] = $this->companyModel->find(session()->id);
    $data['company']['brand'] = $BrandModel
      ->where('companies_id', session()->id)
      ->where('id', $this->desencriptar($_GET['brand']))
      ->first();

    /*=====================================
    Compañias Smartway y No-Smartway
    =====================================*/

    $data['company']['brand']['fleets'] = $BrandsFleetsModel
      ->select('c.name as company_name, c.direccion, cat.name as categoria, f.name, f.id, Brands_Fleets.id as brands_fleets_id, Brands_Fleets.ton_km, Brands_Fleets.tot_km, Brands_Fleets.avg_payload, Brands_Fleets.measure_type, Brands_Fleets.carrier')
      ->join('Brands b', 'b.id = Brands_Fleets.brands_id', 'left')
      ->join('Fleets f', 'f.id = Brands_Fleets.fleets_id', 'left')
      ->join('Companies c', 'c.id = f.companies_id', 'left')
      ->join('Categories cat', 'cat.id = f.categories_id', 'left')
      ->where('Brands_Fleets.brands_id', $this->desencriptar($_GET['brand']))
      ->where('b.measure_year', date('Y'))
      ->find();

    $data['main_menu'] = "brand";
    $data['active_menu'] = "datos_de_actividad";
    echo view('layout/base', $data);
  }

  /**
   * Funcion para Guardar Datos de Actividad de Brands
   * Entidades: Empresas Usuarias
   * 
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 18/10/2021
   * @return view
   */
  public function brandsGuardarDatosDeActividad()
  {

    /*=====================================
    PREPARAMOS DATA
    =====================================*/

    $data = [];

    if (isset($_POST)) {
      foreach ($_POST as $key => $value) {
        $k = explode('#', $key);
        $data[$k[0]][$k[1]] = $value;
      }
    }

    /*=====================================
    CARGAMOS MODELOS A UTILIZAR
    =====================================*/

    $BrandsFleetsModel = new BrandsFleetsModel();

    /*=====================================
    GUARDAMOS INFORMACIÓN
    =====================================*/
    $complete = true;
    foreach ($data as $key => $value) {
      if (!isset($value['carrier'])) {
        $value['carrier'] = 0;
      }

      switch ($value['measure_type']) {
        case 1:
          $value['avg_payload'] = null;
          if(empty($value['ton_km']) || empty($value['tot_km'])){
            // echo "AAAAA";
            $complete = false;
          }
          break;
        case 2:
          $value['tot_km'] = null;
          if(empty($value['ton_km']) || empty($value['avg_payload'])){
            // echo "BBBBB";
            $complete = false;
          }

          break;
        case 3:
          $value['ton_km'] = null;
          if(empty($value['tot_km']) || empty($value['avg_payload'])){
            // echo "CCCCC";
            $complete = false;
          }


          break;
        case 4:
          $value['ton_km'] = null;
          $value['avg_payload'] = null;
          break;
      }
      if ($complete) {
        $BrandsFleetsModel->save($value);
      }
    }
    if ($complete) {
      $response['ok'] = 1;
      $response['mensaje'] = "Información guardada correctamente";
    }else{
      $response['ok'] = 2;
      $response['mensaje'] = "Información incompleta";
    }

    return json_encode($response);
  }

  /**
   * Funcion para traer las Clases   
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   */
  public function traerClases()
  {
    if ($this->request->getMethod() == 'post') {

      $VclassModel = new VclassModel();

      /*=====================================
      OBTENEMOS LAS CLASES
      =====================================*/

      if (isset($_POST['ids'])) {
        return json_encode($VclassModel->find($_POST['ids']));
      } else {
        return ($VclassModel->findAll());
      }
    }
  }

  /**
   * Funcion para validar la empresa
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function validarEmpresa()
  {
    if ($this->request->getMethod() == 'post') {

      /*=====================================
      CARGAMOS MODELOS A UTILIZAR
      =====================================*/
      $validations = new Validations();

      $company_id = session()->id;

      $result = $validations->companyEvaluate($company_id);

      $response['ok'] = 1;
      $response['mensaje'] = "Información validada correctamente";
      $response['result'] = $result;

      return json_encode($response);
    }
  }

  /**
   * Funcion para regresar pantalla (modal) Resutlados de Validación de Empresa
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function resultadoValidacionEmpresa()
  {

    $result = $_POST;

    /*=====================================
    FIELDS NAMES
    =====================================*/

    $fields_names = [
      "km_tot" => 'kilómetros recorridos totales',
      'km/l' => 'Kilomestros por litro',
      'km_empty' => 'kilómetros recorridos vacios',
      'load_volume' => 'Volumen de carga del camión (metros cúbicos)',
      'ralenti' => 'Ralenti',
      'payload_avg' => 'Carga útil promedio (toneladas) únicamente el peso de la carga',
      'ralenti_days' => 'Dias de ralenti',
      'ralenti_hours_large' => 'Horas diarias de ralentí de larga duración',
      'ralenti_hours_short' => 'Horas diarias de ralentí de corta duración',
    ];

    /*=====================================
    VALIDAMOS SI UNA FLOTA TIENE CLASES 
    CON RESULTADOS DE VALIDACION SUPERIOR A 0, 
    DE LO CONTRARIO ELIMINAMOS FLOTA DE LA LISTA
    =====================================*/

    foreach ($result as $fleet => $combustibles) {
      foreach ($combustibles as $combustible => $clases) {
        foreach ($clases as $clase => $fields) {
          foreach ($fields as $field => $value) {
            if ($value == 0) {
              unset($result[$fleet][$combustible][$clase][$field]);
            }
          }
          if (empty($result[$fleet][$combustible][$clase])) {
            unset($result[$fleet][$combustible][$clase]);
          }
        }
        if (empty($result[$fleet][$combustible])) {
          unset($result[$fleet][$combustible]);
        }
      }
      if (empty($result[$fleet])) {
        unset($result[$fleet]);
      }
    }

    /*=====================================
    VERIFICAMOS EL ARREGLO RESULTANTE DE LA VALIDACION ANTERIOR
    SI EXISTEN DATOS, CREAMOS MENSAJES DE ERROR
    =====================================*/
    if (!empty($result)) {
      $lista = "<ul>";
      foreach ($result as $fleet => $combustibles) {

        $lista .= "<li>Flota: $fleet";

        foreach ($combustibles as $combustible => $clases) {

          $lista .= "
            <ul>
            <li>Combustible: $combustible             
            <ul>
            ";

          foreach ($clases as $clase => $fields) {
            $lista .= "
                <li>Clase: $clase
                 <ul>";

            foreach ($fields as $field => $value) {
              $lista .= "<li>$fields_names[$field]</li>";
            }

            $lista .= "
                </ul>
                </li>";
          }

          $lista .= "
            </ul>
            </li>
            </ul>";
        }

        $lista .= "</li>";
      }

      $lista .= "</ul>";
    }

    $data['result'] = $result;
    $data['lista'] = isset($lista) ? $lista : null;

    echo view('Empresas/inicio/resultadoValidacionEmpresa', $data);
  }

  /**
   * Funcion para cambiar status de flotas y terminar Empresa
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function terminarEmpresa()
  {
    if ($this->request->getMethod() == 'post') {

      /*=====================================
      CARGAMOS MODELOS A UTILIZAR
      =====================================*/
      $calculations = new Calculations();
      $companyModel = new CompaniesModel();
      $email = new Email();
      $usersModel = new UsersModel();

      $company_id = session()->id;

      $result = $calculations->evaluate($company_id, date('Y'), true);

      session()->setFlashdata(
        'success',
        'Empresa cerrada correctamente!'
      );

      $response['ok'] = 1;
      $response['mensaje'] = "Empresa cerrada correctamente!";

      $company = $companyModel -> where('id',$company_id) -> first();
      $users = $usersModel -> findAll();

      $to = 'transporte.limpio@semarnat.gob.mx';

      $subject = 'Una empresa mandó sus datos a validación';
      $message = "La empresa $company[name] envió sus datos a validación";

      $email -> send($subject,$message,$to,true);


      return json_encode($response);
    }
  }

  /**
   * Funcion para mostrar resultados de la empresa
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function showResults()
  {


    $measure_year = null;
    $calculations = new Calculations();
    $results = new Results();
    // echo "<br/><br/><br/><br/><br/><br/>--$measure_year";
    if ($this->request->getMethod() == 'post') {

      // /*=====================================
      // CARGAMOS MODELOS A UTILIZAR
      // =====================================*/
      // $results = new Results();

      // $company_id = session()->id;

      // $result = $results->showResults($company_id, date('Y'));

      // session()->setFlashdata(
      //   'success',
      // );

      // $response['ok'] = 1;

      // return json_encode($response);

      $measure_year = $this->request->getVar('measure_year');
      // echo "<br/><br/><br/><br/><br/><br/>POST--$measure_year";
    }
    // echo "<br/><br/><br/><br/><br/><br/>After--$measure_year";

    $measure_year = empty($measure_year) ? date('Y') : $measure_year;

    $company_id = session()->id;

    $calculations->evaluate($company_id, $measure_year);

    $result = $results->showResults($company_id, $measure_year, true, 'pre');

    // session()->setFlashdata(
    //   'success',
    // );

    // $response['ok'] = 1;

    // return json_encode($response);
  }

  /**
   * Funcion para mostrar resultados de la empresa usuaria
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function showResultsU()
  {


    $measure_year = null;
    $calculations = new Calculations();
    $results = new Results();
    // echo "<br/><br/><br/><br/><br/><br/>--$measure_year";
    if ($this->request->getMethod() == 'post') {

      // /*=====================================
      // CARGAMOS MODELOS A UTILIZAR
      // =====================================*/
      // $results = new Results();

      // $company_id = session()->id;

      // $result = $results->showResults($company_id, date('Y'));

      // session()->setFlashdata(
      //   'success',
      // );

      // $response['ok'] = 1;

      // return json_encode($response);

      $measure_year = $this->request->getVar('measure_year');
      // echo "<br/><br/><br/><br/><br/><br/>POST--$measure_year";
    }
    // echo "<br/><br/><br/><br/><br/><br/>After--$measure_year";

    $measure_year = empty($measure_year) ? date('Y') : $measure_year;

    $company_id = session()->id;

    $calculations->usersEvaluate($company_id, $measure_year);

    $result = $results->showResultsU($company_id, $measure_year, true, 'pre');

    // session()->setFlashdata(
    //   'success',
    // );

    // $response['ok'] = 1;

    // return json_encode($response);
  }

  /**
   * Funcion para mostrar resultados de la empresa
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function downloadReport()
  {

    $report = new Results();


    if (session()->get('type') == 1) {
      $report->pdf(session()->get('id'), date('Y'));
    }elseif (session()->get('type') == 2){
      $report->pdfU(session()->get('id'), date('Y'));
    }



  }

  /**
   * Funcion para terminar empresa Usuaria
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   * @return View
   */
  public function terminarEmpresaUsuaria()
  {
    if ($this->request->getMethod() == 'post') {

      /*=====================================
      CARGAMOS MODELOS A UTILIZAR
      =====================================*/

      $brandsModel = new BrandsModel();
      $companiesModel = new CompaniesModel();
      $brands = $brandsModel -> where('companies_id',session()->id) -> where('measure_year',date('Y')) -> findAll();

      foreach($brands as $b){
        $brandsModel -> update($b['id'],['status' => 100]);
        $companiesModel -> update(session()->id,['rev_year'=>date('Y')]);
      }

      $calculations = new Calculations();

      $company_id = session()->id;

      // $result = $calculations->evaluate($company_id, date('Y'));

      session()->setFlashdata(
        'success',
        'Información enviada correctamente.'
      );

      $response['ok'] = 1;
      $response['mensaje'] = "Empresa terminada correctamente";

      return json_encode($response);
    }
  }

  public function tooltips()
  {
    $data['mensaje'] = $_POST['tipo'];
    echo view('Empresas/componentes/tooltip', $data);
  }

  /**
   * Funcion para mostrar alertas
   * @Author: luis07hernandez05@outlook.es
   * @Created: 10/11/2021
   */
  public function alerta()
  {
    $data['mensaje'] = $_POST['mensaje'];
    echo view('Empresas/componentes/alert', $data);
  }

  /*=====================================
  FUNCIONES AUXILIARES DENTRO DEL CONTROLADOR
  =====================================*/

  /**
   * Funcion para validar si existe la flota y pertenece a la compañia actualmente logeada
   * Info: Requiere que el ID de la tabla Fleets este en la URL como variable GET con el nombre flota y encriptada.
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   */
  private function validarSiExisteFlotaYQuePertenceAlUsuarioActual()
  {
    if (!isset($_GET['flota'])) {
      return false;
    }

    //Desencriptamos id
    $flota_id = $this->desencriptar($_GET['flota']);

    if ($flota = $this->fleetsModel->where('companies_id', session()->id)->where('id', $flota_id)->first()) {
      return $flota;
    }

    return false;
  }

  /**
   * Funcion para validar la relacion entre una flota y combustible y que este activo
   * Info: Requiere que el ID de la tabla Fleets_Fuels este en la URL como variable GET con el nombre ff y encriptada.
   * @author Luis Hernandez <luis07hernandez05@outlook.es> 
   * @created 10/10/2021
   */
  private function validarFlotaCombustibleActivo()
  {

    $Fleets_FuelsModel = new FleetsFuelsModel();

    //Desencriptamos id
    $Fleets_Fuels_id = $this->desencriptar($_GET['ff']);

    $_Fleet_Fuel = $Fleets_FuelsModel->find($Fleets_Fuels_id);

    if ($_Fleet_Fuel && $_Fleet_Fuel['active'] == '1') {
      return $_Fleet_Fuel;
    }

    return false;
  }

  private function desencriptar($str)
  {
    //Desencriptamos id
    return $this->encrypter->decrypt(hex2bin($str));
  }

  private function encriptar($str)
  {
    return bin2hex($this->encrypter->encrypt($str));
  }

  private function validarRevYear(){
    //True si esta en validacion. False si no.
    return $this->company['rev_year'] == date('Y') ? true : false;      
  }  
} //Controller
