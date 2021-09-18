<?php

namespace CodeIgniter\Commands\Server;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

/**
 * Launch the PHP development server
 *
 * Not testable, as it throws phpunit for a loop :-/
 *
 * @codeCoverageIgnore
 */
class Swoole extends BaseCommand {

    /**
     * Minimum PHP version
     *
     * @var string
     */
    protected $minPHPVersion = '7.3';

    /**
     * Group
     *
     * @var string
     */
    protected $group = 'CodeIgniter';

    /**
     * Name
     *
     * @var string
     */
    protected $name = 'swoole';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Launches the CodeIgniter PHP-Production Server.';

    /**
     * Usage
     *
     * @var string
     */
    protected $usage = 'swoole';

    /**
     * Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * Options
     *
     * @var array
     */
    protected $options = [
        '--port' => 'The HTTP Host Port [default: "9999"]',
    ];

    /**
     * Run the server
     *
     * @param array $params Parameters
     *
     * @return void
     */
    public function run(array $params) {
        $port = (int) (CLI::getOption('port') ?? 9999);
        CLI::write("Starting server in $port");
        $server = new \Swoole\HTTP\Server("127.0.0.1", $port);
        // $server->set([
        //     'worker_num' => 2,
        //     'task_worker_num' => 2,
        //     'upload_tmp_dir' => '/data/uploaded_files/',
        //     // ...
        // ]);
        $server->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) use ($server) {
            //isap wrap
            $_HEADER = $request->header;
            $_SERVER = $request->server;
            $_GET = $request->get;
            $_POST = $request->post;
            @$_REQUEST = ($_GET ?? []) + ($_POST ?? []);
            $_COOKIE = $request->cookie;
            $_FILES = $request->files;
            $_HEADER = array_change_key_case($_HEADER, CASE_UPPER);
            $_SERVER = array_change_key_case($_SERVER, CASE_UPPER);
            

            $_SERVER['DOCUMENT_ROOT'] = realpath('..');
            ob_start();
            \CodeIgniter\Config\Services::router();
            $router = Services::router();
            /** @var \CodeIgniter\Router\Router $router */
            $router->handle();
//                    var_dump($cn);
            // chdir('..');
//            var_dump($_SERVER);

            //    include 'swoole_rewrite.php';

            return $response->end(ob_get_clean());
        });
        $server->start();
    }

}
