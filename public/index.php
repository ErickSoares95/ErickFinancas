<?php 
use ErickFinancas\Application;
use ErickFinancas\Plugins\Routeplugin;
use ErickFinancas\Plugins\ViewPlugin;
use ErickFinancas\ServiceContainer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

require_once __DIR__ .'/../vendor/autoload.php';

$serviceContainer = new ServiceContainer();

$app = new Application($serviceContainer);

//integrar com Aura/Router
$app->plugin(new Routeplugin());
$app->plugin(new ViewPlugin());

//rota sem parametros
//$app->get('/', function (RequestInterface $request) use ($app) {
//    $view = $app->service('view.renderer');
//    return $view->render('test.html.twig', ['name' => 'Erick Soares']);
//});

$app->get('/{name}', function (ServerRequestInterface $request) use ($app) {
    $view = $app->service('view.renderer');
    return $view->render('test.html.twig', ['name' => $request->getAttribute('name')]);
});

//trabalhando com parametros ServerRequestInterface. Se for sem parametros apenas RequestInterface
$app->get('/home/{name}', function (ServerRequestInterface $request) {
    $response = new Response();
    $response->getBody()->write("response com emitter do diactoros");
    return $response;
});

//chamada da execução da applicação

$app->start();