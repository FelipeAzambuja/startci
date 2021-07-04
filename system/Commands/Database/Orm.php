<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeIgniter\Commands\Database;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

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
        if (file_exists("../app/Models/$className.php"))
            if (strtoupper(CLI::prompt('Overwrite file ? (y,n)', null, 'required')) != "Y")
                return false;
        file_put_contents("../app/Models/$className.php", $file);
    }

    function up($params)
    {
        if (isset($params[1]))
            $name = ucfirst($params[1]);
        else
            $name = '*';
            
        foreach (glob('../app/Models/'.$name.'.php') as $key => $value) {//pegar todas as classes e namespaces
            $name = basename($value);
            $className = str_replace(".php", "", $name);
            $fqn = "\App\Models\\" . $className;
            if (!class_exists($fqn))
                CLI::error("The class $fqn not found");
            $c = new $fqn();
            $c->create();

        }
    }
}
