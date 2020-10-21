<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller {

    public function index() {
        return view('welcome_message.tpl',[
            'nome' => 'Felipe'
        ]);
    }

    function teste() {
        if(is_post()){
            
        }
        return view('teste');
    }

    //--------------------------------------------------------------------
}
