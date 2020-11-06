<?php

namespace CodeIgniter;

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
    
    function set($value_name,$value) {
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
