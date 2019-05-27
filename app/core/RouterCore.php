<?php
namespace Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Classe principal de tratamento de rotas
 * Exemplo de definição de rotas
 * $router->add('/product', function(){
 *       return new Response(
 *           ProductController::get()
 *       );
 *  });
 */
class RouterCore implements HttpKernelInterface
{
    /*
     * @var RouteCollection
     */
    protected $rotas = [];

    public function __construct()
    {
        $this->rotas = new RouteCollection();
    }

    public function handle(
        Request $request,
        $type = HttpKernelInterface::MASTER_REQUEST,
        $catch = true
    ) {
        $context = new RequestContext();
        $context->fromRequest($request);

        $matcher = new UrlMatcher($this->rotas, $context);
        try {
            $attributes = $matcher->match($context->getPathInfo());

            $controller = $attributes['controller'];
            unset($attributes['controller']);
            $response = call_user_func_array($controller, $attributes);
        } catch (ResourceNotFoundException $e) {
            $response = new Response(
                'URL não encontrada.',
                Response::HTTP_NOT_FOUND
            );
        }

        return $response;
    }

    public function add($route, $controller)
    {
        $this->rotas->add(
            $route,
            new Route($route, ['controller' => $controller])
        );
    }
}
