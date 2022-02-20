<?php

namespace App\Models;

/**
 * @property integer $id AutoIncrement
 * @property string $login
 * @property string $email
 * @property string $nome
 * @property string $senha
 * @property mediumblob $foto
 * @property string $created_at
 * @property string $updated_at
 * @table users
 */
class Users extends \CodeIgniter\ORM
{
    function seed()
    {
        return [
            [
                'login' => 'felipe',
                'email' => 'felipe@newbgp.com.br',
                'nome' => 'felipe',
                'senha' => md5(123)
            ],
            [
                'login' => 'paola',
                'email' => 'paola@newbgp.com.br',
                'nome' => 'paola',
                'senha' => md5(123)
            ],
        ];
    }
    function __get($name)
    {
        switch ($name) {
            case '':
                return '';
                break;
        }
    }
}

/** 
 * @return Users
 */
function model_users()
{
    return new Users();
}
