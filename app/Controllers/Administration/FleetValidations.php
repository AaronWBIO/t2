<?php

namespace App\Controllers\Administration;

use App\Models\Administration\UsersModel;
use App\Models\Empresas\CompaniesModel;
use App\Models\Administration\CacheModel;
use App\Models\Empresas\ContactsModel;

use App\Controllers\BaseController;
use App\Libraries\Validations;
use App\Libraries\Email;
use App\Models\Administration\FuelsModel;
use App\Models\Administration\VclassModel;
use App\Models\Empresas\Comments;
use App\Models\Empresas\Fleet_Fuels_Vclass_Quantity;
use App\Models\Empresas\Fleet_Fuels_Vclass_Reduction;
use App\Models\Empresas\Fleets_Fuels_Vclass_Travels;
use App\Models\Empresas\FleetsFuelsModel;
use App\Models\Empresas\FleetsModel;

include_once APPPATH . '/ThirdParty/j/j.func.php';

class FleetValidations extends BaseController
{

	public function index($year = null)
	{

		helper(['form']);

		$fleetsModel = new FleetsModel();

		$fleets = $fleetsModel
			->select('Fleets.name, Fleets.id, c.name as cname, c.id as cid, Fleets.json')
			->join('Companies c', 'c.id = Fleets.companies_id', 'left')
			->where('Fleets.status >=', 100)
			->where('Fleets.status <', 200)
			->where('c.type', 1)
			->orderBy('c.name', 'ASC')
			->orderBy('Fleets.name', 'ASC')
			->findAll();

		$data['title'] = 'Flotas por validar';
		$data['content'] = 'Administration/fleetValidations/index';

		$data['fleets'] = $fleets;

		echo view('layout/base', $data);
	}

	/**
	 * Funcion para mostrar la informacion general de una flota
	 * @author <luis07hernandez05@outlook.es>
	 * @created 23/10/2021
	 * 
	 * @return array[CompaniesModel]
	 */
	public function informacionGeneral()
	{

		/*=====================================
		CARGAMOS MODELOS A UTILIZAR
		=====================================*/

		$fuelsModel = new FuelsModel();

		/*=====================================
		TRAEMOS COMPAÑIA
		=====================================*/

		$company = $this->traerCompany();

		/*=====================================
		TRAEMOS Y VALIDAMOS ID DE FLOTA
		=====================================*/

		$uri = service('uri');
		$fleet_id = $uri->getSegment(5);
		if (!is_numeric($fleet_id) || !isset($company['fleets'][$fleet_id])) {
			return redirect()->to('/Administration/FleetValidations');
		}

		/*=====================================
		PREPARAMOS INFORMACIÓN 
		NOTA: ESTA INFORMACIÓN SE ADAPTA A COMO SE UTILIZA EN LA VISTA: Empresas/flotas/informacionGeneral
		=====================================*/
		$data['administrator'] = true;
		$data['company'] = $company;
		$data['fleet'] = $company['fleets'][$fleet_id];
		$data['fuels'] = $fuelsModel->where('id !=', 8)->find();
		$data['content'] = 'Empresas/flotas/informacionGeneral';
		$data['main_menu'] = 'flotas';
		$data['active_menu'] = 'informacionGeneral';
		echo view('layout/base', $data);
	}

	/**
	 * Funcion para mostar las clases del combustible de la flota
	 * @author <luis07hernandez05@outlook.es>
	 * @created 23/10/2021
	 * 
	 * @return array[CompaniesModel]
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
		TRAEMOS COMPAÑIA
		=====================================*/

		$company = $this->traerCompany();

		/*=====================================
		TRAEMOS Y VALIDAMOS ID DE FLOTA
		=====================================*/

		$uri = service('uri');
		$fleet_id = $uri->getSegment(5);
		if (!is_numeric($fleet_id) || !isset($company['fleets'][$fleet_id])) {
			return redirect()->to('/Administration/FleetValidations');
		}

		/*=====================================
		VALIDAMOS EL COMBUSTIBLE
		=====================================*/

		$_Fleet_Fuel = $this->traerFlotaCombustible();
		if (!$_Fleet_Fuel) {
			return redirect()->to('/Administration/FleetValidations');
		}

		/*=====================================
		PREPARAMOS INFORMACIÓN 
		NOTA: ESTA INFORMACIÓN SE ADAPTA A COMO SE UTILIZA EN LA VISTA: Empresas/flotas/combustibles/clases
		=====================================*/
		$data['administrator'] = true;
		$data['clases_seleccionadas'] = empty($fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id'])) ? [] : $fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id']);
		$data['vClasses'] = $VclassModel->findAll();
		$data['company'] = $company;
		$data['fleet'] = $company['fleets'][$fleet_id];
		$data['content'] = 'Empresas/flotas/combustibles/contenedor';
		$data['formulario'] = 'clases';
		$data['main_menu'] = 'flotas';
		$data['active_menu'] = 'flotas';
		$data['combustible_seleccionado'] = $fuelsModel->find($_Fleet_Fuel['fuels_id']);
		echo view('layout/base', $data);
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
		TRAEMOS COMPAÑIA
		=====================================*/

		$company = $this->traerCompany();

		/*=====================================
		TRAEMOS Y VALIDAMOS ID DE FLOTA
		=====================================*/

		$uri = service('uri');
		$fleet_id = $uri->getSegment(5);
		if (!is_numeric($fleet_id) || !isset($company['fleets'][$fleet_id])) {
			return redirect()->to('/Administration/FleetValidations');
		}

		/*=====================================
		VALIDAMOS EL COMBUSTIBLE
		=====================================*/

		$_Fleet_Fuel = $this->traerFlotaCombustible();
		if (!$_Fleet_Fuel) {
			return redirect()->to('/Administration/FleetValidations');
		}

		/*=====================================
		PREPARAMOS INFORMACIÓN 
		NOTA: ESTA INFORMACIÓN SE ADAPTA A COMO SE UTILIZA EN LA VISTA: Empresas/flotas/combustibles/quantity
		=====================================*/

		$fleets_fuels_vclass_quantity_data = $Fleets_Fuels_Vclass_QuantityModel
			->where('fleets_fuels_id', $_Fleet_Fuel['id'])
			->find();

		$data['administrator'] = true;
		$data['fleets_fuels_vclass_quantity_data'] = $fleets_fuels_vclass_quantity_data;
		$data['clases_seleccionadas'] = empty($fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id'])) ? [] : $fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id']);
		$data['vClasses'] = $VclassModel->findAll();
		$data['company'] = $company;
		$data['fleet'] = $company['fleets'][$fleet_id];
		$data['content'] = 'Empresas/flotas/combustibles/contenedor';
		$data['formulario'] = 'quantity';
		$data['main_menu'] = 'flotas';
		$data['active_menu'] = 'flotas';
		$data['combustible_seleccionado'] = $fuelsModel->find($_Fleet_Fuel['fuels_id']);
		echo view('layout/base', $data);
	}

	/**
	 * Funcion para ver pantalla en donde se ingresan los datos de Año modelo y motor | travels
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
		$validations = new Validations();

		/*=====================================
		TRAEMOS COMPAÑIA
		=====================================*/

		$company = $this->traerCompany();

		/*=====================================
		TRAEMOS Y VALIDAMOS ID DE FLOTA
		=====================================*/

		$uri = service('uri');
		$fleet_id = $uri->getSegment(5);
		if (!is_numeric($fleet_id) || !isset($company['fleets'][$fleet_id])) {
			return redirect()->to('/Administration/FleetValidations');
		}

		/*=====================================
		VALIDAMOS EL COMBUSTIBLE
		=====================================*/

		$_Fleet_Fuel = $this->traerFlotaCombustible();
		if (!$_Fleet_Fuel) {
			return redirect()->to('/Administration/FleetValidations');
		}

		/*=====================================
		CARGAMOS INFORMACIÓN
		=====================================*/

		$fuel = $fuelsModel->find($_Fleet_Fuel['fuels_id']);

		/*=====================================
        VALIDAMOS FLOTA COMPLETA
        =====================================*/

		$response_validaciones_flota = $validations->fleetEval($_Fleet_Fuel['fleets_id']);

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
						'fleets_fuels_id' => $_Fleet_Fuel['id'],
						'color' => $status
					];
					$inputsNames[] = [
						'name' => $current_class['id'] . '#ralenti_hours_short',
						'status' => $status,
						'vclass_id' => $current_class['id'],
						'field' => 'ralenti_hours_short',
						'fleets_fuels_id' => $_Fleet_Fuel['id'],
						'color' => $status
					];
				} else if ($field_name == 'km/l') {
					$inputsNames[] = [
						'name' => $current_class['id'] . '#lts_tot',
						'status' => $status,
						'vclass_id' => $current_class['id'],
						'field' => 'lts_tot',
						'fleets_fuels_id' => $_Fleet_Fuel['id'],
						'color' => $status
					];
				} else {
					$inputsNames[] = [
						'name' => $current_class['id'] . '#' . $field_name,
						'status' => $status,
						'vclass_id' => $current_class['id'],
						'field' => $field_name,
						'fleets_fuels_id' => $_Fleet_Fuel['id'],
						'color' => $status
					];
				}
			}
		}

		/*=====================================
		PREPARAMOS INFORMACIÓN 
		NOTA: ESTA INFORMACIÓN SE ADAPTA A COMO SE UTILIZA EN LA VISTA: Empresas/flotas/combustibles/quantity
		=====================================*/

		$Fleets_Fuels_Vclass_Travel_data = $Fleets_Fuels_Vclass_TravelModel
			->where('fleets_fuels_id', $_Fleet_Fuel['id'])
			->find();

		$data['validacion'] = $inputsNames;
		$data['administrator'] = true;
		$data['Fleets_Fuels_Vclass_Travel_data']  = $Fleets_Fuels_Vclass_Travel_data;
		$data['clases_seleccionadas'] = empty($fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id'])) ? [] : $fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id']);
		$data['vClasses'] = $VclassModel->findAll();
		$data['company'] = $company;
		$data['fleet'] = $company['fleets'][$fleet_id];
		$data['content'] = 'Empresas/flotas/combustibles/contenedor';
		$data['formulario'] = 'travels';
		$data['main_menu'] = 'flotas';
		$data['active_menu'] = 'flotas';
		$data['combustible_seleccionado'] = $fuelsModel->find($_Fleet_Fuel['fuels_id']);
		echo view('layout/base', $data);
	}

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

		$data['administrator'] = true;
		echo view('Empresas/flotas/combustibles/travel_class_fuel_comentario', $data);
	}

	public function validarFlotasCombustiblesTravels()
	{
		if ($this->request->getMethod() == 'post') {

			/*=====================================
			CARGAMOS MODELOS A UTILIZAR
			=====================================*/

			$validations = new Validations();
			$FleetsFuelsModel = new FleetsFuelsModel();
			$VclassModel = new VclassModel();
			$fuelsModel = new FuelsModel();

			/*=====================================
			CARGAMOS INFORMACIÓN
			=====================================*/

			$fleet_fuel = $FleetsFuelsModel->find($_POST['ff']);
			$fuel = $fuelsModel->find($fleet_fuel['fuels_id']);

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
			$response['ok'] = 1;
			$response['mensaje'] = "Información guardada correctamente";

			return json_encode($response);
		}
	}

	/**
	 * Funcion para ver pantalla en donde se ingresan los datos de Año modelo y motor | reduction
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

		/*=====================================
		TRAEMOS COMPAÑIA
		=====================================*/

		$company = $this->traerCompany();

		/*=====================================
		TRAEMOS Y VALIDAMOS ID DE FLOTA
		=====================================*/

		$uri = service('uri');
		$fleet_id = $uri->getSegment(5);
		if (!is_numeric($fleet_id) || !isset($company['fleets'][$fleet_id])) {
			return redirect()->to('/Administration/FleetValidations');
		}

		/*=====================================
		VALIDAMOS EL COMBUSTIBLE
		=====================================*/

		$_Fleet_Fuel = $this->traerFlotaCombustible();
		if (!$_Fleet_Fuel) {
			return redirect()->to('/Administration/FleetValidations');
		}

		/*=====================================
		PREPARAMOS INFORMACIÓN 
		NOTA: ESTA INFORMACIÓN SE ADAPTA A COMO SE UTILIZA EN LA VISTA: Empresas/flotas/combustibles/quantity
		=====================================*/

		$Fleets_Fuels_Vclass_Reduction_data = $Fleets_Fuels_Vclass_ReductionModel
			->where('fleets_fuels_id', $_Fleet_Fuel['id'])
			->find();

		$data['administrator'] = true;
		$data['Fleets_Fuels_Vclass_Reduction_data']  = $Fleets_Fuels_Vclass_Reduction_data;
		$data['clases_seleccionadas'] = empty($fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id'])) ? [] : $fleetsModel->fleetsFuelsVclass($_Fleet_Fuel['id']);
		$data['vClasses'] = $VclassModel->findAll();
		$data['company'] = $company;
		$data['fleet'] = $company['fleets'][$fleet_id];
		$data['content'] = 'Empresas/flotas/combustibles/contenedor';
		$data['formulario'] = 'reduction';
		$data['main_menu'] = 'flotas';
		$data['active_menu'] = 'flotas';
		$data['combustible_seleccionado'] = $fuelsModel->find($_Fleet_Fuel['fuels_id']);
		echo view('layout/base', $data);
	}

	/**
	 * Funcion para validar que la flota le pertenezca a la compañia
	 * @author <luis07hernandez05@outlook.es>
	 * @created 23/10/2021
	 * 
	 * @return array[CompaniesModel]
	 */
	private function traerCompany()
	{
		/*=====================================
		CARGAMOS MODELOS A UTILIZAR
		=====================================*/

		$companiesModel = new CompaniesModel();
		$fleetsModel = new FleetsModel();
		$Fleets_FuelsModel = new FleetsFuelsModel();

		/*=====================================
		OBTENEMOS SEGMENTOS DE URL
		=====================================*/

		$uri = service('uri');
		$company_id = $uri->getSegment(4);

		/*=====================================
		VALIDAMOS QUE EXISTA LA COMPAÑIA
		=====================================*/

		if (!$company = $companiesModel->find($company_id)) {
			return false;
		}

		/*=====================================
		TRAEMOS TODAS LAS FLOTAS DE LA COMPAÑIA CON STATUS MAYOR A 100
		=====================================*/
		$fleets = $fleetsModel
			->where('companies_id', $company_id)
			->where('status >=', 100)
			->where('status <', 200)
			->find();

		/*=====================================
		OBTENEMOS LOS COMBUSTIBLES SELECCIONADOS PARA CADA FLOTA
		=====================================*/

		foreach ($fleets as $key => $fleet) {
			$company['fleets'][$fleet['id']] = $fleet;
			$company['fleets'][$fleet['id']]['fuels'] = $fleetsModel->fuels($fleet['id']);
		}

		return $company;
	}

	/**
	 * Funcion para validar la relacion entre una flota y combustible y que este activo
	 * Info: Requiere que el ID de la tabla Fleets_Fuels este en la URL como variable GET con el nombre ff
	 * @author Luis Hernandez <luis07hernandez05@outlook.es> 
	 * @created 10/10/2021
	 * 
	 * @return FleetsFuelsModel
	 */
	private function traerFlotaCombustible()
	{
		$Fleets_FuelsModel = new FleetsFuelsModel();

		//Desencriptamos id
		$Fleets_Fuels_id = $_GET['ff'];

		$_Fleet_Fuel = $Fleets_FuelsModel->find($Fleets_Fuels_id);

		if ($_Fleet_Fuel && $_Fleet_Fuel['active'] == '1') {
			return $_Fleet_Fuel;
		}

		return false;
	}

	public function refuseFleet($companies_id,$fleets_id){

		$fleetsModel = new FleetsModel();
		$companiesModel = new CompaniesModel();
		$cacheModel = new CacheModel();
		$contactsModel = new ContactsModel();

		$newDataCompany = [
			'rev_year' => null,
		];

		$companiesModel -> update($companies_id,$newDataCompany);

		$newDataFleet = [
			'status' => 90,
		];

		$fleetsModel -> update($fleets_id,$newDataFleet);

		$cacheModel -> where('fleets_id',$fleets_id) -> delete();

		if ($this->request->getMethod() == 'post') {
			$email = new Email();
			$fleet = $fleetsModel -> where('id',$fleets_id) -> first();
			$company = $companiesModel -> where('id',$companies_id) -> first();
			$contacts = $contactsModel -> where('companies_id',$companies_id) -> findAll();

			$refuseComment = $this->request->getVar('refuseComment');

			$message = "La información de la flota $fleet[name] necesita modificarse. <br/>";
			$message .= "Los administradores dejaron el siguiente comentario: <br/> $refuseComment";

			$to = array();
			$to[] = $company['email'];

			foreach ($contacts as $c) {
				$to[] = $c['email'];
			}

			$email -> send('Se requiere modificar su información en la plataforma transporte limpio',$message, $to);


		}


		echo '{"ok":"1"}';	
	}

	public function acceptFleet($fleets_id){
		$fleetsModel = new FleetsModel();
		$companiesModel = new CompaniesModel();
		$contactsModel = new ContactsModel();


		$email = new Email();
		$fleet = $fleetsModel -> where('id',$fleets_id) -> first();
		$company = $companiesModel -> where('id',$fleet['companies_id']) -> first();
		$contacts = $contactsModel -> where('companies_id',$fleet['companies_id']) -> findAll();

		$refuseComment = $this->request->getVar('refuseComment');

		// $message = "La información de la flota $fleet[name] fue validada correctamente. <br/>";
		$message = "Su reporte de desempeño fue validado correctamente.<br/>";
		$message .= "Por favor ingrese nuevamente a la plataforma Transporte Limpio, donde podrá descargar su reporte de desempeño validado.";
		// $message .= "Los administradores dejaron el siguiente comentario: <br/> $refuseComment";

		$to = array();
		$to[] = $company['email'];

		foreach ($contacts as $c) {
			$to[] = $c['email'];
		}

		$email -> send('La validación de tu flota se realizó correctamente',$message, $to);


		$newDataFleet = [
			'status' => 200,
		];

		$fleetsModel -> update($fleets_id,$newDataFleet);

		echo '{"ok":"1"}';	
	}

	public function getValidValues($fleets_id){
		$fleetsModel = new FleetsModel();
		$fuelsModel = new FuelsModel();
		$vclassModel = new VclassModel();
		$fleetsFuelsModel = new FleetsFuelsModel();
		$travelsModel = new Fleets_Fuels_Vclass_Travels();

		$fuelsDB = $fuelsModel -> findAll();
		$fuels = array();
		foreach ($fuelsDB as $f) {
			$fuels[$f['name']] = $f;
		}

		$vclassDB = $vclassModel -> findAll();
		$vclass = array();
		foreach ($vclassDB as $f) {
			$vclass[$f['name']] = $f;
		}


		$fleet = $fleetsModel -> where('id',$fleets_id) -> first();
		$json = $fleet['json'];

		$valids = json_decode($json,true);
		$ff = array();
		$tr = array();
		foreach ($valids as $fuel => $classValids) {
			foreach ($classValids as $vc => $fields) {
				foreach ($fields as $field => $val) {
					if($val > 0){
						if(!isset($ff[$fleets_id][$fuels[$fuel]['id']])){
							$fleetFuel = $fleetsFuelsModel 
							-> where('fleets_id',$fleets_id)
							-> where('fuels_id',$fuels[$fuel]['id'])
							-> first();
							$ff[$fleets_id][$fuels[$fuel]['id']] = $fleetFuel;
						}
						$fleetFuel = $ff[$fleets_id][$fuels[$fuel]['id']];

						if(!isset( $tr[$fleetFuel['id']][$vclass[$vc]['id']] )  ){
							$travels = $travelsModel
							-> where('fleets_fuels_id',$fleetFuel['id'])
							-> where('vclass_id',$vclass[$vc]['id'])
							-> first();
							$tr[$fleetFuel['id']][$vclass[$vc]['id']] = $travels;
						}
						$travels = $tr[$fleetFuel['id']][$vclass[$vc]['id']];
						// print2($travels);

						switch($field){
							case "km_tot":
								$value = $travels['km_tot'];
								break;
							case "km/l":
								$value = $travels['lts_tot'] != 0 ? $travels['km_tot']/$travels['lts_tot'] : 0;
								break;
							case "km_empty":
								$value = $travels['km_empty'];
								break;
							case "payload_avg":
								$value = $travels['payload_avg'];
								break;
							case "ralenti_days":
								$value = $travels['ralenti_days'];
								break;
							case "ralenti_hours_large":
								$value = $travels['ralenti_hours_large'];
								break;
							case "ralenti_hours_short":
								$value = $travels['ralenti_hours_short'];
								break;
						}
						$valids[$fuel][$vc][$field] = $value;
					}
				}
			}
		}



		return atj($valids);

	}

}
