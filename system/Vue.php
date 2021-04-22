<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeIgniter;

/**
 * Description of Vue
 *
 * @author felipe
 */
class Vue {

    var $varname = '';
    var $data = [];

    function __construct($varname='vue') {
        $this->varname = $varname;
        $this->data = @$_POST['vue'][$varname];//???
    }

    function data($data = null) {
        if ($data === null) {
            return $this->data;//???
        } else {
            foreach ($data as $key => $value) {
                $value = json_encode($value);
                echo "{$this->varname}.{$key} = {$value};";
            }
        }
    }

}