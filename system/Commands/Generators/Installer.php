<?php

namespace CodeIgniter\Commands\Generators;

use CodeIgniter\CLI\BaseCommand;

class Installer extends BaseCommand{
     /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Generators';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'make:installer';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Generate a installer file to deploy';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:installer [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [
        '--namespace' => 'Set root namespace. Default: "APP_NAMESPACE".',
        '--suffix'    => 'Append the component title to the class name (e.g. User => UserConfig).',
        '--force'     => 'Force overwrite existing file.',
    ];

    /**
     * Actually execute a command.
     */
    public function run(array $params)
    {

    }
}