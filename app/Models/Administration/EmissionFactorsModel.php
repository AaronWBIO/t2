<?php namespace App\Models\Administration;

use CodeIgniter\Model;
use App\Models\Administration\PollutantsModel;
use App\Models\Administration\VclassModel;
use App\Models\Administration\FuelsModel;


class EmissionFactorsModel extends Model{

	protected $table = 'Emissions_Factors';
	protected $allowedFields = ['measure_year','fuels_id','vclass_id','year','pollutants_id','ralenti','value','range','delete_at'];

	protected $beforeInsert = ['beforeInsert'];
	protected $beforeUpdate = ['beforeUpdate'];
	protected $useSoftDeletes = true;
	
	protected function beforeInsert(array $data){

		// $data['data']['uploaded_by'] = session()->get('id');
		// $data['data']['created_at'] = date('Y-m-d H:i:s');
		return $data;
	}

	protected function beforeUpdate(array $data){

		// $data = $this->passwordHash($data);
		return $data;
	}

	public function getYears(){

		$yearsDB = $this->select('DISTINCT(measure_year)')
		-> orderBy('measure_year','DESC')
		-> findAll();

		$years = array();
		foreach ($yearsDB as $y) {
			$years[$y['measure_year']] = $y['measure_year'];
		}
		
		return $years;
	}

	public function createEF($year,$pollutants_id,$fuels_id,$type){

		// print2([$year,$pollutants_id,$fuels_id,$type]);
		$pollutantsModel = new PollutantsModel();
		$vclassModel = new VclassModel();
		$fuelsModel = new FuelsModel();

		$pollutants = $pollutantsModel -> findAll();
		$vclass = $vclassModel -> findAll();
		$fuels = $fuelsModel -> findAll();

		// print2($pollutants);
		// exit();

		$numYears = 33;

		$k = 0;
		$pn = 0;
		$cn = 0;
		$fn = 0;
		$batch1 = [];
		$batch2 = [];
		$batch3 = [];
		$batch4 = [];
		$batch5 = [];
		$num = 0;
		foreach ($pollutants as $p) {
			if($p['id'] != $pollutants_id){continue;}

			foreach ($fuels as $f) {
				if($f['id'] != $fuels_id){continue;}

				if($p['code'] == 'CO2'){
					$newData = [
						'measure_year' => $year,
						'fuels_id' => $f['id'],
						'pollutants_id' => $p['id'],
						'ralenti' => 0,
					];
					// $batch1[] = $newData;
					$this -> insert($newData);

					continue;
				}

				foreach ($vclass as $c) {
					for($i = 0; $i<$numYears; $i++){
						// print2($i);
						// if($num = 3000000){
						// 	break 3;
						// }
						switch ($type) {
							case '0':
								// print2('case0');
								$newData = [
									'measure_year' => $year,
									'fuels_id' => $f['id'],
									'vclass_id' => $c['id'],
									'pollutants_id' => $p['id'],
									'ralenti' => 0,
									'year' => $year-$i+1 ,
								];
								$batch2[] = $newData;

								break;
							case '1':
								// print2('case1');
								$newDataRalenti = [
									'measure_year' => $year,
									'fuels_id' => $f['id'],
									'vclass_id' => $c['id'],
									'pollutants_id' => $p['id'],
									'ralenti' => 1,
									'year' => $year-$i+1 ,
								];
								$batch1[] = $newDataRalenti;

								break;
							case '2':
								// print2('case2');
								$newDataRalenti = [
									'measure_year' => $year,
									'fuels_id' => $f['id'],
									'vclass_id' => $c['id'],
									'pollutants_id' => $p['id'],
									'ralenti' => 2,
									'year' => $year-$i+1 ,
								];
								$batch1[] = $newDataRalenti;

								break;
							case '3':
								// print2('case3');
								$newDataVelocity = [
									'measure_year' => $year,
									'fuels_id' => $f['id'],
									'vclass_id' => $c['id'],
									'pollutants_id' => $p['id'],
									'ralenti' => 3,
									'year' => $year-$i+1,
									'range' => 0
								];
								$batch3[] = $newDataVelocity;
								// $this -> insert($newDataVelocity);

								$newDataVelocity['range'] = 1;
								$batch3[] = $newDataVelocity;
								// $this -> insert($newDataVelocity);
								$newDataVelocity['range'] = 2;
								$batch3[] = $newDataVelocity;
								// $this -> insert($newDataVelocity);
								$newDataVelocity['range'] = 3;
								$batch3[] = $newDataVelocity;
								// $this -> insert($newDataVelocity);
								$newDataVelocity['range'] = 4;
								$batch3[] = $newDataVelocity;
								break;
							
							default:
								// code...
								break;
						}
						// $this -> insert($newDataRalenti);

						// $this -> insert($newDataRalenti);

						// $this -> insert($newData);

						if($type == 3){

						}
						// $this -> insert($newDataVelocity);
					}
				}
			}
				
		}
		// print2($batch1);
		if(!empty($batch1)){
			$this -> insertBatch($batch1);
		}
		if(!empty($batch2)){
			$this -> insertBatch($batch2);
		}
		if(!empty($batch3)){
			$this -> insertBatch($batch3);
		}
		// $this -> insertBatch($batch2);
		// $this -> insertBatch($batch3);
		

		// echo "$pn * $cn * $fn = $k<br/>";
		// exit();
	}

	public function getEF($year,$pollutants_id,$fuels_id,$type){

		$pollutantsModel = new PollutantsModel();
		$vclassModel = new VclassModel();
		$fuelsModel = new FuelsModel();

		$pollutants = $pollutantsModel -> findAll();
		$vclass = $vclassModel -> findAll();
		$fuels = $fuelsModel -> findAll();

		switch ($type) {
			case 0:
				$ralenti = 0;
				break;
			case 1:
				$ralenti = 1;
				break;
			case 2:
				$ralenti = 2;
				break;
			case 3:
				$ralenti = 3;
				break;
			
			default:
				$ralenti = 0;
				break;
		}

		$feDB = $this
		-> select('Emissions_Factors.*, f.name as fname, f.code as fcode, 
			p.name as pname, p.code as pcode, c.name as cname, c.code as ccode, c.icon')
		-> join('Fuels f','f.id = Emissions_Factors.fuels_id','left')
		-> join('Pollutants p','p.id = Emissions_Factors.pollutants_id','left')
		-> join('Vclass c','c.id = Emissions_Factors.vclass_id','left')
		-> where('ralenti',$ralenti)
		-> where('measure_year',$year)
		-> where('fuels_id',$fuels_id)
		-> where('p.id',$pollutants_id)
		-> orderBy('c.name','ASC')
		-> orderBy('Emissions_Factors.year','DESC')
		-> findAll();


		return $feDB;
	}

	public function getAllEF($year){

		$pollutantsModel = new PollutantsModel();
		$vclassModel = new VclassModel();
		$fuelsModel = new FuelsModel();

		$pollutants = $pollutantsModel -> findAll();
		$vclass = $vclassModel -> findAll();
		$fuels = $fuelsModel -> findAll();

		$feDB = $this
		-> select('Emissions_Factors.*, f.name as fname, f.code as fcode, 
			p.name as pname, p.code as pcode, c.name as cname, c.code as ccode, c.icon')
		-> join('Fuels f','f.id = Emissions_Factors.fuels_id','left')
		-> join('Pollutants p','p.id = Emissions_Factors.pollutants_id','left')
		-> join('Vclass c','c.id = Emissions_Factors.vclass_id','left')
		-> where('measure_year',$year)
		// -> where('ralenti',$ralenti)
		// -> where('fuels_id',$fuels_id)
		// -> where('p.id',$pollutants_id)
		-> findAll();


		return $feDB;
	}


}


?>