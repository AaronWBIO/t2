<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Controllers\Login;

class LoginCheck implements FilterInterface{
    public function before(RequestInterface $request, $arguments = null){
        // Do something here
        
        $uri = service('uri');
        if(strtolower($uri->getSegment(1)) == 'administration'){

            if (session()-> get('isLoggedInAdmin') != 1) {
                if (strtolower($uri->getSegment(2)) != 'login') {
                    return redirect()->to('/administration/login');
                }
            }

        }

        if(strtolower($uri->getSegment(1)) == 'empresas'){
            if (session()-> get('isLoggedIn') != 1) {
                if (strtolower($uri->getSegment(2)) != 'login') {
                    return redirect()->to('/empresas/login/tr');
                }
            }

        }

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        // Do something here
    }
}
