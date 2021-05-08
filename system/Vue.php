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

    function __construct($varname = 'vue') {
        $this->varname = $varname;
    }

    function set($var, $value) {
        $value = json_encode($value);
        echo "{$this->varname}.{$var} = {$value};";
    }

    function get($key = null) {
        if ($key)
            return $_POST['vue'][$this->varname][$key] ?? null;
        else
            return $_POST['vue'][$this->varname] ?? null;
    }

}
