<?php

namespace CodeIgniter\Validation;

class UserRules
{
    function valid_user($str, $fields, $data)
    {
        if (class_exists('\App\Models\Users')) {
            $m = \App\Models\Users::init();
            if ($m->validate_email($data['email'] ?? null, $data['password'] ?? null))
                return true;
            if ($m->validate_name($data['name'] ?? null, $data['password'] ?? null))
                return true;
        }
        
        if (table('users')->where([
            'email' => $data['email'] ?? null,
            'password' => password_hash($data['password'] ?? null,PASSWORD_BCRYPT)
        ])->first())
            return true;
        if (table('users')->where([
            'name' => $data['name'] ?? null,
            'password' => password_hash($data['password'] ?? null,PASSWORD_BCRYPT)
        ])->first())
            return true;
        return false;
    }
}
