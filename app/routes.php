<?php
require_once "../vendor/autoload.php";

use Controller\ProductController;
use Controller\CategoryController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Definição das rotas da aplicação
 * Padrão:
 *  $app->route('/product', function(){
 *       return new Response("Index");
 *  });
 */

/**
 * Rotas referentes a manipulação
 * de
 * category
 */
//Retorna todas categorias
$router->add('/category', function () {
    return new Response(
        CategoryController::get()
    );
});
//Retorna uma categoria
$router->add('/category/single/{id}', function ($id) {
    return new Response(
        CategoryController::get($id)
    );
});
//Insere uma categoria através de $_POST
$router->add('/category/insert', function () {
    $request = Request::createFromGlobals();
    CategoryController::insert(
        $request->request->get('category')
    );
    header("Location: ".BASE."categories.php");
});
//Atualiza uma categoria através de $_POST
$router->add('/category/update', function () {
    $request = Request::createFromGlobals();
    CategoryController::update(
        $request->request->get('category')
    );
    header("Location: ".BASE."categories.php");
});
//Delete uma categoria
$router->add('/category/delete/{id}', function ($id) {
    CategoryController::delete(
        $id
    );
    header("Location: ".BASE."categories.php");
});
/**
 * Rotas referentes a manipulação
 * de
 * product
 */
$router->add('/product', function () {
    return new Response(
        ProductController::get()
    );
});
$router->add('/product/single/{id}', function ($id) {
    return new Response(
        ProductController::get($id)
    );
});
$router->add('/product/insert', function () {
    $request = Request::createFromGlobals();
    ProductController::insert(
        $request->request->get('product')
    );
    header("Location: ".BASE."products.php");
});
$router->add('/product/update', function () {
    $request = Request::createFromGlobals();
    ProductController::update(
        $request->request->get('product')
    );
    header("Location: ".BASE."products.php");
});
$router->add('/product/delete/{id}', function ($id) {
    ProductController::delete(
        $id
    );
    header("Location: ".BASE."products.php");
});
