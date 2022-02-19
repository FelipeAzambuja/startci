<?php

namespace App\Models;

/**
 * @property integer $id AutoIncrement
 * @property string $
 * @property string $created_at
 * @property string $updated_at
 * @table clientes
 */
class Clientes extends \CodeIgniter\ORM
{

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
 * @return Clientes
 */
function model_clientes()
{
    return new Clientes();
}
