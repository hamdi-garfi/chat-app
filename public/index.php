<?php

use Symfony\Component\Dotenv\Dotenv;
use App\Kernel;

require dirname(__DIR__) . '/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');


$kernel = new Kernel($_SERVER['APP_ENV'],$_SERVER['APP_DEBUG']);
$kernel::load();

// router en fonction les paramètres de l'url
$pageName = isset($_GET['p']) ? $_GET['p'] : "default.login";

$page = explode('.', $pageName);
$controller = 'App\Controller\\' . ucfirst($page[0]) . 'Controller';
$action = $page[1];
$controller = new $controller();
$controller->$action();
                