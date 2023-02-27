<?php 
namespace App\Controllers\Empresas;

use App\Controllers\BaseController;
use App\Models\Empresas\MoFleets  as moFleets;

class ClsRespuesta {
  public function __set($name, $value) {
    $this->{$name} = $value;
  }
}

class Crud extends BaseController{

  public function __construct(){
    $this->db = \Config\Database::connect();
  }

  public function guardarFleets(){
    var_dump($this->request->getPost('companies_id')); return false;
    /*$moFleets = new moFleets;
    $x        = 0;

    $this->db->transStart(); //agregar >> true << y habilitar: var_dump($this->db->getLastQuery()); despues de transComplete();

    //guardar fleets
    foreach ($this->request->getPost('companies_id') as $key => $value) {
      $insFleets['companies_id'] = 
      $moFleets->save($insFleets); //Si se envia el id de la tabla hace un update 
    }
    
    $this->db->transComplete();
    //var_dump($this->db->getLastQuery()); 

    if ($this->db->transStatus() === FALSE){
      $this->db->transRollback();
    }else{
      $this->db->transCommit();
    }*/
  } //Guardar fleets


} //Controller
