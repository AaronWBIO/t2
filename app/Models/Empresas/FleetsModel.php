<?php

namespace App\Models\Empresas;

use CodeIgniter\Model;

class FleetsModel extends Model
{
  protected $table      = 'Fleets';
  protected $primaryKey = 'id';
  protected $useSoftDeletes = true;

  // ========================
  protected $allowedFields  = ['id', 'companies_id', 'measure_year', 'name', 'carga_dedicada', 
    'carga_consolidada', 'acarreo', 'paqueteria', 'expedito', 'caja_seca', 'refrigerado', 
    'plataforma', 'cisterna', 'chasis', 'carga_pesada', 'madrina', 'mudanza', 'utilitario', 
    'especializado', 'usa', 'canada', 'mexico', 'short', 'large', 'intermediary', 'intermediaryPercent',
    'descripcion','status','categories_id','json','type'];
  // ========================

  public function fuels($fleet_id)
  {
    $tQuery = "SELECT Fleets_Fuels.id,Fleets_Fuels.fuels_id, Fuels.name FROM Fleets JOIN Fleets_Fuels ON Fleets_Fuels.fleets_id = Fleets.id JOIN Fuels ON Fleets_Fuels.fuels_id = Fuels.id WHERE Fleets_Fuels.active = 1 AND Fleets_Fuels.fleets_id = $fleet_id";

    $query = $this->db->query($tQuery);
    if ($query->getNumRows() > 0) {
      return $query->getResult();
    }
  }

  public function fleets($company)
  {
    $tQuery = " 
	Select 
		com.id   as idCompani,
		com.name as nameCompani,
		fl.* 
	from Fleets fl 
	LEFT JOIN Companies com ON com.id = fl.companies_id" .
      " WHERE fl.companies_id = " . $company['id'] . "";

    //die($tQuery);
    $query = $this->db->query($tQuery);
    if ($query->getNumRows() > 0) {
      return $query->getResult();
    }
  }

  public function fleetsFuelsVclass($fleet_fuels_id)
  {
    $tQuery = " 
    SELECT Vclass.*, Fleets_Fuels_Vclass.euro5, Fleets_Fuels_Vclass.euro6 FROM Vclass 
    JOIN Fleets_Fuels_Vclass 
    ON Vclass.id = Fleets_Fuels_Vclass.vclass_id 
    WHERE Fleets_Fuels_Vclass.Fleets_Fuels_id = $fleet_fuels_id";    

    //die($tQuery);
    $query = $this->db->query($tQuery);
    if ($query->getNumRows() > 0) {
      return $query->getResult('array');
    }
  }
} //Model