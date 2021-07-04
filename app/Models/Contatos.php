<?php

namespace App\Models;

use CodeIgniter\Collection;

/**
 * @property integer $id AutoIncrement
 * @property string $name
 * @property \App\Models\Pessoas $pessoas
 * @property string $created_at
 * @property string $updated_at
 * @table contatos
 */
class Contatos extends \CodeIgniter\ORM {

    function __get($name)
    {
        switch($name){
            case '':
                return '';
                break;
        }
    }

}
