<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeIgniter\Commands\Database;

use CodeIgniter\ClassHelper;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

/**
 * Description of Db
 *
 * @author felipe
 */
class Orm extends BaseCommand
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
    protected $name = 'orm';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Manage orm';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'orm up|down|read force';

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * the Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Ensures that all migrations have been run.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $cmd = $params[0] ?? null;
        $this->$cmd($params);
    }
    function create($params)
    {
        
        if (!isset($params[1]))
            $params[1] = CLI::prompt('Class name ', null, 'required');
        $table = strtolower($params[1]);
        $className = ucfirst($params[1]);
        $file = '';
        $file .= "<?php" . PHP_EOL;
        $file .= "" . PHP_EOL;
        $file .= "namespace App\Models;" . PHP_EOL;
        $file .= "" . PHP_EOL;
        $file .= "/**" . PHP_EOL;
        $file .= " * @property integer \$id AutoIncrement" . PHP_EOL;
        $file .= " * @property string \$" . PHP_EOL;
        $file .= " * @property string \$created_at" . PHP_EOL;
        $file .= " * @property string \$updated_at" . PHP_EOL;
        $file .= " * @table $table" . PHP_EOL;
        $file .= " */" . PHP_EOL;
        $file .= "class $className extends \CodeIgniter\ORM {" . PHP_EOL;
        $file .= "" . PHP_EOL;
        $file .= "    function __get(\$name)" . PHP_EOL;
        $file .= "    {" . PHP_EOL;
        $file .= "        switch(\$name){" . PHP_EOL;
        $file .= "            case '':" . PHP_EOL;
        $file .= "                return '';" . PHP_EOL;
        $file .= "                break;" . PHP_EOL;
        $file .= "        }" . PHP_EOL;
        $file .= "    }" . PHP_EOL;
        $file .= "" . PHP_EOL;
        $file .= "}" . PHP_EOL;
        $file .= "" . PHP_EOL;
        if (file_exists("../app/Models/$className.php"))
            if (strtoupper(CLI::prompt('Overwrite file ? (y,n)', null, 'required')) != "Y")
                return false;
        file_put_contents("../app/Models/$className.php", $file);
        $file = '';
        $file = file_get_contents('../app/Common.php') . PHP_EOL;;
        $file .= "/** " . PHP_EOL;
        $file .= " * @return \App\Models\\".$className . PHP_EOL;
        $file .= " */" . PHP_EOL;
        $file .= "function model_$table(){" . PHP_EOL;
        $file .= "  return new \App\Models\\".$className."();" . PHP_EOL;
        $file .= "}" . PHP_EOL . PHP_EOL;
        file_put_contents('../app/Common.php', $file);
    }

    function down()
    {
        $con = db_connect();
        $database = env('database.default.database');
        try {
            $con->simpleQuery("drop database $database");
            $con->simpleQuery("create database $database");
        } catch (\Throwable $th) {
        }
    }
    function up()
    {
        cache()->delete('startci_models_create');
        $con = db_connect();
        try {
            $con->simpleQuery("SET foreign_key_checks = 0");
        } catch (\Throwable $th) {
        }

        $path = '../app/Models';
        $fqcns = array();
        $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        $phpFiles = new RegexIterator($allFiles, '/\.php$/');
        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2; // Skip namespace keyword and whitespace
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0] && T_WHITESPACE === $tokens[$index + 1][0] && T_STRING === $tokens[$index + 2][0]) {
                    $index += 2;
                    $fqcns[] = $namespace . '\\' . $tokens[$index][1];
                    break;
                }
            }
        }
        foreach ($fqcns as $key => $value) { //pegar todas as classes e namespaces
            $fqn = $value;
            if (!class_exists($fqn))
                CLI::error("The class $fqn not found");
            $c = new $fqn();
            $c->create();
        }
        try {
            $con->simpleQuery("SET foreign_key_checks = 1");
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
