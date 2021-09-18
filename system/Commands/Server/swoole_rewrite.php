<?php
// $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
// $fcpath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR;
// $path = $fcpath . ltrim($uri, '/');
// if ($uri !== '/' && (is_file($path) || is_dir($path))) {
//     return false;
// }

 $paths = new \Config\Paths();

 $app = require rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php';

 $app->run();
echo 'batata';
