<?php
namespace App\Models\Empresas;
use CodeIgniter\Model;

class Mo_diesel extends Model
{
  //protected $table      = '';
  //protected $primaryKey = '';
  protected $returnType = 'object';

  // ========================
     //protected $allowedFields  = [''];
  // ========================
  public function datosTransporte(){
    $datos = Array(  
      $object = (object) 
        [
          'iCodDta' => '1',
          'vCodigo' => 'Clase A',
          'vIcon'   => 'logo.jpg',
          'vNombre' => '5 - 5.5 ton',
        ],
      $object = (object)
        [
          'iCodDta' => '2',
          'vCodigo' => 'Clase B',
          'vIcon'   => 'logo.jpg',
          'vNombre' => '4 - 4.5 ton',
        ],
      $object = (object)
        [
          'iCodDta' => '3',
          'vCodigo' => 'Clase C',
          'vIcon'   => 'logo.jpg',
          'vNombre' => '4 - 4 ton',
        ],
      $object = (object)
        [
          'iCodDta' => '4',
          'vCodigo' => 'Clase D',
          'vIcon'   => 'logo.jpg',
          'vNombre' => '5 - 4.5 ton',
        ],
      $object = (object)
        [
          'iCodDta' => '5',
          'vCodigo' => 'Clase E',
          'vIcon'   => 'logo.jpg',
          'vNombre' => '5 - 5 ton',
        ],
      $object = (object)
        [
          'iCodDta' => '5',
          'vCodigo' => 'Clase E',
          'vIcon'   => 'logo.jpg',
          'vNombre' => '5 - 5 ton',
        ]
    );

    return $datos;
  }

  public function getAnios(){
    $anios = array("2021", "2020", "2019", "2018", "2017");

    return $anios;
  }
}