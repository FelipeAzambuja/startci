<?php

namespace App\Models\Vendas\C1;

use CodeIgniter\Collection;

/**
 * @property integer $id AutoIncrement
 * @property string $name
 * @property \App\Models\Pessoas $pessoa
 * @property string $created_at
 * @property string $updated_at
 * @table contatos
 */
class Venda extends \CodeIgniter\ORM {

    function __get($name)
    {
        switch($name){
            case 'pessoa':
                return model_pessoas()->byId($this->pessoa);
                break;
        }
    }

}
