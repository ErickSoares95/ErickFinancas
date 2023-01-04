<?php 
use ErickFinancas\Application;
use ErickFinancas\Plugins\Routeplugin;
use ErickFinancas\ServiceContainer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

require_once __DIR__ .'/../vendor/autoload.php';

$serviceContainer = new ServiceContainer();

$app = new Application($serviceContainer);

//integrar com Aura/Router
$app->plugin(new Routeplugin());

//registrar a rota
$app->get('/', function (RequestInterface $request) {
    var_dump($request->getUri());die();
    echo "Hello world";
});

$app->get('/home/{name}', function (ServerRequestInterface $request) {
    $response = new Response();
    $response->getBody()->write("response com emitter do diactoros");
    return $response;
});

//chamada da execução da applicação

$app->start();