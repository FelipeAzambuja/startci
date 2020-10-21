<?php

namespace CodeIgniter;

class DatasetController extends Controller {

    public $table = null;
    public $where = '';
    public $validation_rules = [];
    public $validation_messages = [];
    public $buffer = 10;

    function index() {
        echo 'Doc ?';
    }

    function refresh() {
        
        return $this->response->setJSON([
            'total_rows' =>table($this->table)->selectMax('id')->get()->getFirstRow()
        ]);
    }

}
