<?php

namespace App\Controllers\Transportistas;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {


        $data['title'] = 'aaa';
        $data['content'] = 'Transportistas/contenido';
        $data['variable1'] = 'VARIABLE1';
        $data['variable2']['sub1'] = 'Sub1';
        $data['variable2']['sub2'] = 'Sub2';


        echo view('layout/base',$data);




        // $data['variable1'] = 'VARIABLE1';
        // $data['variable2']['sub1'] = 'Sub1';
        // $data['variable2']['sub2'] = 'Sub2';

        // echo view('layout/base',$data);

    }
}
