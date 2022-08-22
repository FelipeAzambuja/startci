<?php

namespace App\Models;

/**
 * @property integer $id AutoIncrement
 * @property string $name
 * @property string $email
 * @property string $roles
 * @property string $type
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 * @table users
 */
class Users extends \CodeIgniter\UserORM {


    function seed(){
        return [
            'name' => 'Admin',
            'email' => 'admin@newbgp.com.br',
            'password' => md5('123'),
            'type' => 'admin',
            'roles' => json_encode(['admin']),
        ];
    }

    function __get($name)
    {
        switch($name){
            case '':
                return '';
                break;
        }
    }

}

