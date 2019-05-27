<?php
require_once "../vendor/autoload.php";
require_once '../app/config.php';

if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_erros', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_erros', 0);
    error_reporting(0);
}

use Core\RouterCore;
use Core\Database;
use Migration\TableCategory;
use Migration\TableProduct;
use Migration\TableProductCategory;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Define as variáveis globais
 */
$request = Request::createFromGlobals();

/**
 * Inicializa a base de dados,
 * as funções devem ser chamadas através do Database
 * no padrão Illuminate\Database\Capsule\Manager
 */
Database::run(new Capsule);
TableCategory::up();
TableProduct::up();
TableProductCategory::up();

/**
 * Router
 * */
$router = new RouterCore();

/**
 * Arquivo para definição das rotas
 */
require_once "../app/routes.php";

/**
 * Resposta
 */
$response = $router->handle($request);
$response->send();
