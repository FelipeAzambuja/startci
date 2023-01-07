<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeIgniter\Commands\Database;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Description of Db
 *
 * @author felipe
 */
class Sql extends BaseCommand
{

    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'Database';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'sql';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Command line sql runner';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'sql SQL';

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        "sql" => "SQL query", "mode" => "Output mode table json data default data", "database" => "CodeIgniter config database",
    ];

    /**
     * the Command's Options
     *
     * @var array
     */
    protected $options = [
    ];

    /**
     * Ensures that all migrations have been run.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $sql  = $params[0] ?? false;
        $mode = $params[1] ?? 'raw';
        $db   = $params[2] ?? null;
        if (!$sql) {
            return false;
        }
        $db     = db_connect($db);
        $result = $db->query($sql);
        if (is_bool($result)) {
            if ($result) {
                die(CLI::write("command executed successfully"));
            } else {
                die(CLI::error("command executed with error " . $db->error()['message']));
            }
        }
        $result = $result->getResult();
        switch ($mode) {
            case 'json':
                $this->respond_json($result);
                break;
            case 'json':
                $this->respond_json($result, false);
                break;
            case 'raw':
                dd($result);
                break;
            case 'table':
                $this->respond_table($result);
                break;

            default:
                CLI::error("Undefined mode");
                break;
        }
        (is_cli()) ? eval(\Psy\sh()) : false;
    }

    public function respond_json($result, $raw = true)
    {
        die(json_encode($result));
    }
    public function respond_table($result)
    {
        if (!$result) {
            CLI::write("No data");
            return true;
        }
        (is_cli()) ? eval(\Psy\sh()) : false;
    }

}
