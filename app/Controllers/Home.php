<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        // $data['title'] = 'aaa';
        $data['content'] = 'home/home';

        echo view('layout/base',$data);

    }
}
