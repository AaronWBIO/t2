<?php

namespace App\Controllers\Administration;

use App\Models\Administration\UsersModel;
use App\Models\Empresas\CompaniesModel;
use App\Models\Empresas\ContactsModel;
use App\Models\Administration\BrandsModel;
use App\Models\Administration\CacheModel;
use App\Models\Administration\CacheUsersModel;
use App\Libraries\Email;

use App\Controllers\BaseController;
use App\Models\Empresas\BrandsFleetsModel;
use App\Models\Empresas\BrandsModel as EmpresasBrandsModel;

include_once APPPATH . '/ThirdParty/j/j.func.php';

class UsersValidations extends BaseController
{

	public function index($year = null)
	{

		helper(['form']);

		$brandsModel = new BrandsModel();

		$fleets = $brandsModel
			->select('Brands.name, Brands.id, c.name as cname, c.id as cid')
			->join('Companies c', 'c.id = Brands.companies_id', 'left')
			->where('Brands.status >=', 100)
			->where('Brands.status <', 200)
			->where('c.type', 2)
			->orderBy('c.name', 'ASC')
			->orderBy('Brands.name', 'ASC')
			->findAll();

		$data['title'] = 'Empresas por validar';
		$data['content'] = 'Administration/usersValidations/index';

		$data['fleets'] = $fleets;

		echo view('layout/base', $data);
	}

	/**
	 * Funcion para mostrar pantalla Agregar Transportistas
	 * Entidades: Empresas Usuarias
	 * 
	 * @author Luis Hernandez <luis07hernandez05@outlook.es> 
	 * @created 18/10/2021
	 * @return view
	 */
	public function brandsTransportistas()
	{
		/*=====================================
    	CARGAMOS MODELOS A UTILIZAR
    	=====================================*/

		$BrandsFleetsModel = new BrandsFleetsModel();
		$BrandModel = new BrandsModel();

		/*=====================================
		TRAEMOS COMPAÑIA
		=====================================*/

		$company = $this->traerCompany();

		/*=====================================
		TRAEMOS Y VALIDAMOS ID BRAND
		=====================================*/
		$uri = service('uri');
		$brand_id = $uri->getSegment(5);
		if (!is_numeric($brand_id) || !isset($company['brands'][$brand_id])) {
			return redirect()->to('/Administration/UsersValidations');
		}

		/*=====================================
		PREPARAMOS INFORMACIÓN 
		NOTA: ESTA INFORMACIÓN SE ADAPTA A COMO SE UTILIZA EN LA VISTA: Empresas/flotas/combustibles/quantity
		=====================================*/

		$data['administrator'] = true;
		$data['content'] = 'Empresas/empresasUsuarias/brands/agregarTransportistas';
		$data['company'] = $company;
		$data['company']['brand'] = $company['brands'][$brand_id];
		$data['main_menu'] = "brand";
		$data['active_menu'] = "agregar_transportistas";
		echo view('layout/base', $data);
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

		/*=====================================
		TRAEMOS COMPAÑIA
		=====================================*/

		$company = $this->traerCompany();

		/*=====================================
		TRAEMOS Y VALIDAMOS ID BRAND
		=====================================*/
		$uri = service('uri');
		$brand_id = $uri->getSegment(5);
		if (!is_numeric($brand_id) || !isset($company['brands'][$brand_id])) {
			return redirect()->to('/Administration/UsersValidations');
		}

		/*=====================================
		PREPARAMOS INFORMACIÓN 
		NOTA: ESTA INFORMACIÓN SE ADAPTA A COMO SE UTILIZA EN LA VISTA: Empresas/flotas/combustibles/quantity
		=====================================*/

		$data['administrator'] = true;
		$data['content'] = 'Empresas/empresasUsuarias/brands/datosDeActividad';
		$data['company'] = $company;
		$data['company']['brand'] = $company['brands'][$brand_id];
		$data['main_menu'] = "brand";
		$data['active_menu'] = "datos_de_actividad";
		echo view('layout/base', $data);
	}

	/**
	 * Funcion para validar que la Brand le pertenezca a la compañia
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
		$EmpresasBrandsModel = new EmpresasBrandsModel();
		$BrandsFleetsModel = new BrandsFleetsModel();

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
		TRAEMOS TODAS LAS BRANDS DE LA COMPAÑIA CON STATUS MAYOR A 100
		=====================================*/
		$brands = $EmpresasBrandsModel
			->where('companies_id', $company_id)
			->where('status >=', 100)
			->where('status <', 200)
			->find();

		/*=====================================
		OBTENEMOS LAS FLOTAS AGREGADAS A CADA BRAND
		=====================================*/

		foreach ($brands as $key => $brand) {
			$company['brands'][$brand['id']] = $brand;
			$company['brands'][$brand['id']]['fleets'] = $BrandsFleetsModel
				->select('c.name as company_name, c.direccion, cat.name as categoria, f.name, f.id, Brands_Fleets.id as brands_fleets_id, Brands_Fleets.ton_km, Brands_Fleets.tot_km, Brands_Fleets.avg_payload, Brands_Fleets.measure_type, Brands_Fleets.carrier')
				->join('Brands b', 'b.id = Brands_Fleets.brands_id', 'left')
				->join('Fleets f', 'f.id = Brands_Fleets.fleets_id', 'left')
				->join('Companies c', 'c.id = f.companies_id', 'left')
				->join('Categories cat', 'cat.id = f.categories_id', 'left')
				->where('Brands_Fleets.brands_id', $brand['id'])
				->where('b.measure_year', date('Y'))
				->where('c.type', 1)
				->find();

			$company['brands'][$brand['id']]['no_sw_fleets'] = $BrandsFleetsModel
				->select('c.name as company_name, c.direccion, cat.name as categoria, f.name, f.id, Brands_Fleets.id as brands_fleets_id, Brands_Fleets.ton_km, Brands_Fleets.tot_km, Brands_Fleets.avg_payload, Brands_Fleets.measure_type, Brands_Fleets.carrier')
				->join('Brands b', 'b.id = Brands_Fleets.brands_id', 'left')
				->join('Fleets f', 'f.id = Brands_Fleets.fleets_id', 'left')
				->join('Companies c', 'c.id = f.companies_id', 'left')
				->join('Categories cat', 'cat.id = f.categories_id', 'left')
				->where('Brands_Fleets.brands_id', $brand['id'])
				->where('b.measure_year', date('Y'))
				->where('c.type', 3)
				->find();
		}

		return $company;
	}

	public function refuseBrand($companies_id,$fleets_id){

		$fleetsModel = new EmpresasBrandsModel();
		$companiesModel = new CompaniesModel();
		$cacheModel = new CacheUsersModel();
		$contactsModel = new ContactsModel();

		$newDataCompany = [
			'rev_year' => null,
		];

		$companiesModel -> update($companies_id,$newDataCompany);

		$newDataFleet = [
			'status' => 91,
		];


		$fleetsModel -> update($fleets_id,$newDataFleet);

		$cacheModel -> where('brands_id',$fleets_id) -> delete();

		if ($this->request->getMethod() == 'post') {

			// print2("AAA");
			$email = new Email();
			$fleet = $fleetsModel -> where('id',$fleets_id) -> first();
			$company = $companiesModel -> where('id',$companies_id) -> first();
			$contacts = $contactsModel -> where('companies_id',$companies_id) -> findAll();

			$refuseComment = $this->request->getVar('refuseComment');

			$message = "La información de la unidad de negocios $fleet[name] necesita modificarse. <br/>";
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

	public function acceptBrands($brands_id){
		$brandsModel = new EmpresasBrandsModel();
		$companiesModel = new CompaniesModel();
		$contactsModel = new ContactsModel();

		$email = new Email();
		$brand = $brandsModel -> where('id',$brands_id) -> first();
		$company = $companiesModel -> where('id',$brand['companies_id']) -> first();
		$contacts = $contactsModel -> where('companies_id',$brand['companies_id']) -> findAll();

		$refuseComment = $this->request->getVar('refuseComment');

		$message = "La información de la unidad de negocio $brand[name] fue validada correctamente. <br/>";
		$message .= "Por favor ingrese nuevamente a la plataforma Transporte Limpio, donde podrá descargar su reporte de desempeño validado.";

		// $message .= "Los administradores dejaron el siguiente comentario: <br/> $refuseComment";

		$to = array();
		$to[] = $company['email'];

		foreach ($contacts as $c) {
			$to[] = $c['email'];
		}

		$email -> send('La validación de tu unidad de negocio se realizó correctamente',$message, $to);


		$newDataFleet = [
			'status' => 200,
		];

		$brandsModel -> update($brands_id,$newDataFleet);

		echo '{"ok":"1"}';	
	}


}
