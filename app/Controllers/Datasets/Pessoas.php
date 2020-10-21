<?php

namespace App\Controllers\Datasets;

class Pessoas extends \CodeIgniter\DatasetController {

    public function __construct() {
        $this->table = 'pessoas';
        $this->where = [
            'ativo' => 1
        ];
    }

}
