<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeIgniter;

/**
 * Description of JS
 *
 * @author felipe
 */
class JS {

    function encode($string) {
        return json_encode($string);
    }

    function console($value) {
        echo 'console.log(' . $this->encode($value) . ');';
    }

    function alert($value) {
        echo 'alert(' . $this->encode($value) . ');';
    }

    function eval($code) {
        echo "$code;";
    }

    function redirect($url, $data = []) {
        echo "location.href={$url}" . (($data) ? '?' . http_build_query($data) : '') . ';';
    }

    function set($value_name, $value) {
        $value = $this->encode($value);
        echo "{$value_name} = $value;";
    }

    public function __call($name, $arguments) {
        foreach ($arguments as $key => $value) {
            $arguments[$key] = $this->encode($value);
        }
        $a = implode(',', $arguments);
        echo "{$name}({$a});";
    }

}
