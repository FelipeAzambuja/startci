<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        return file_get_contents('nuxtjs/dist');
    }
}
