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
class JS
{
    public function setInterval($url, $data, $time)
    {
        ?>
        setInterval(()=>{
            startci.call(<?=json_encode($url)?>,<?=json_encode($data)?>);
        },<?=json_encode($time)?>);
        <?php
}
    public function setTimeout($url, $data, $time = 100)
    {
        ?>
        setTimeout(()=>{
            startci.call(<?=json_encode($url)?>,<?=json_encode($data)?>);
        },<?=json_encode($time)?>);
        <?php
}


    public function show_errors()
    {
        $errors      = valid()->getErrors();
        $errors_keys = array_keys($errors);
        $form_keys   = array_keys(form());
        $valids      = array_values(array_filter($form_keys, function ($v) use ($errors_keys) {
            return !in_array($v, $errors_keys);
        }));
        foreach ($valids as $key => $value) {
            ?>
                try {
                    document.getElementById("invalid<?=$value?>").innerHTML = '';
                    document.getElementById("invalid<?=$value?>").classList.add('d-none');
                    document.getElementsByName("<?=$value?>")[0].classList.remove('is-invalid');
                    document.getElementsByName("<?=$value?>")[0].classList.add('is-valid');
                } catch (error) {

                }
                <?php
}
        foreach ($errors as $key => $value) {
            ?>
                    try {
                        document.getElementById("invalid<?=$key?>").innerHTML = '<?=$value?>';
                        document.getElementById("invalid<?=$key?>").classList.add('d-block');
                        document.getElementsByName("<?=$key?>")[0].classList.add('is-invalid');
                    } catch (error) {
                        console.log("Error on <?= $key ?> <?= $value ?>");
                        console.error(error);
                    }
                <?php
}
    }
    public function encode($string)
    {
        return json_encode($string);
    }

    public function console($value)
    {
        echo 'console.log(' . $this->encode($value) . ');';
    }

    public function alert($value)
    {
        echo 'alert(' . $this->encode($value) . ');';
    }

    function eval($code) {
        echo "$code;";
    }

    public function redirect($url, $data = [])
    {
        echo "location.href='{$url}" . (($data) ? '?' . http_build_query($data) : '') . '\';';
    }

    public function set($value_name, $value)
    {
        $value = $this->encode($value);
        echo "{$value_name} = $value;";
    }

    public function __call($name, $arguments)
    {
        foreach ($arguments as $key => $value) {
            $arguments[$key] = $this->encode($value);
        }
        $a = implode(',', $arguments);
        echo "{$name}({$a});";
    }
}
