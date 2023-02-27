<?php
namespace App\Models\Empresas;
use CodeIgniter\Model;

class FleetsArrayModel extends Model
{
  protected $table      = 'fleets';
  protected $primaryKey = 'id';  
  protected $useSoftDeletes = true;

  // ========================
  protected $allowedFields  = ['id','companies_id','measure_year','name','carga_dedicada','carga_consolidada','acarreo','paqueteria','expedito','caja_seca','refrigerado','plataforma','cisterna','chasis','carga_pesada','madrina','mudanza','utilitario','especializado','usa','canada','mexico','short','large','intermediary','intermediaryPercent'];
  // ========================

} //Model