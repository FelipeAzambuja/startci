<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;

use App\Models\Users;

class Auth extends Controller
{
    function login()
    {
        extract(form());
        if ($user = (new Users())->where([
            'nome' => $nome,
            'senha' => md5($senha)
        ])->first())
            return $this->response->setJSON([
                'token' => jwt_encode($user->id)
            ]);
            else
            return $this->response->setJSON([
                'mensagem' => 'Deu merda'
            ])->setStatusCode(500);
    }
    function logout()
    {
    }
    function user()
    {
        return $this->response->setJSON([
            'user' => user()
        ]);
    }
}
