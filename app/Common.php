<?php

use Config\Database;
use Config\Services;
use Stringy\Stringy;
use function Stringy\create;

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

/**
 * 
 * @param string $value
 * @return Stringy
 */
function str(string $value): Stringy {
    return create($value);
}

function is_post() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function is_get() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function form($key = null, $default = null) {
    if ($key != null) {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    } else {
        return $_REQUEST;
    }
}

/**
 * 
 * @param type $name
 * @return \CodeIgniter\Database\BaseBuilder
 */
function table(string $name, $db = null): \CodeIgniter\Database\BaseBuilder {
    return db_connect($db)->table($name);
}

function create_table(string $table, array $fields, string $db = null): void
{
    $forge = Database::forge($db);
    $db = db_connect($db);
    $tables = $db->listTables();
    if (in_array($table, $tables)) {
        $field_names = $db->getFieldNames($table);
        foreach ($fields as $k => $field) {
            if (is_numeric($k)) {
                $key_name = $field;
            } else {
                $key_name = $k;
            }
            if (!in_array($key_name, $field_names)) {
                if (strpos($field, '.') !== false) {
                    $forge->addField([
                        $key_name => [
                            'type' => 'INT',
                            'null' => true
                        ]
                    ]);
                    $field = explode('.', $field);
                    $forge->addKey($key_name);
                    $forge->addForeignKey($key_name, $field[0], $field[1]);

                    $forge->addColumn($table, [
                        $key_name => [
                            'type' => 'INT',
                            'null' => true
                        ]
                    ]);
                } else {
                    if (is_numeric($k)) {
                        $forge->addColumn($table, [
                            $key_name => [
                                'type' => 'text',
                                'null' => true
                            ]
                        ]);
                    } else {
                        $forge->addColumn($table, [
                            $key_name => [
                                'type' => $field,
                                'null' => true
                            ]
                        ]);
                    }
                }
            }
        }
    } else {
        $forge->addField('id');
        foreach ($fields as $k => $field) {
            if (strpos($field, '.')) {
                $forge->addField([
                    $k => [
                        'type' => 'INT',
                        'null' => true
                    ]
                ]);
                $field = explode('.', $field);
                $forge->addKey($k);
                $forge->addForeignKey($k, $field[0], $field[1]);
            } else {

                if (is_numeric($k)) {
                    $forge->addField([
                        $field => [
                            'type' => 'text',
                            'null' => true
                        ]
                    ]);
                } else {
                    $forge->addField([
                        $k => [
                            'type' => $field,
                            'null' => true
                        ]
                    ]);
                }
            }
        }
        $forge->addField('created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        $forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $forge->createTable($table, true);
    }
}

/*
  /**
 * 
 * @return \CodeIgniter\Validation\Validation
 */

function valid(): \CodeIgniter\Validation\Validation {
    $valid = Services::validation();
    return $valid;
}

function form_error($field, $template = 'single') {
    echo valid()->showError($field, $template);
}

function user($table='users') {
    return table($table)->where('id', session()->get('id'))->get()->getFirstRow();
}


/**
 * 
 * @param string $data
 * @return string|boolean
 */
function excel_date($data, $format = 'd/m/Y', $erro = false) {
    if (!$format) {
        $format = 'd/m/Y';
    }
    $data_excel = \Carbon\Carbon::create(1900, 1, 1);
    if (is_numeric($data)) {
        return $data_excel->clone()->addDays(($data - 2))->format($format);
    } elseif (is_date('d/m/Y', $data)) {
        return \Carbon\Carbon::createFromFormat('d/m/Y', $data)->format($format);
        ;
    } elseif (is_date('Y-m-d', $data)) {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $data)->format($format);
        ;
    } else {
        return $erro;
    }
}

/**
 * 
 * @param string $data
 * @return \Carbon\Carbon
 */
function carbon(string $data = null): \Carbon\Carbon {
    if ($data == null) {
        return \Carbon\Carbon::now();
    }
    if (is_date('d/m/Y', $data)) {
        return \Carbon\Carbon::createFromFormat('d/m/Y', $data);
    } elseif (is_date('Y-m-d', $data)) {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $data);
    } else {
        $nullformat = new stdClass();
        $nullformat->format = function($format) {
            return null;
        };
        return \Carbon\Carbon::create(0);
    }
}

function is_date($format, $date) {
    return (DateTime::createFromFormat($format, $date)) !== false;
}

function row_default($table, $values = [], $db = null) {
    $v = [];
    foreach (db_connect($db)->getFieldNames($table) as $key => $value) {
        $v[$value] = (!isset($values[$value])) ? null : $values[$value];
    }
    return (object)$v;
}