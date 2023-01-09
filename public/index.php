<?php 
use ErickFinancas\Application;
use ErickFinancas\Plugins\AuthPlugin;
use ErickFinancas\Plugins\DbPlugin;
use ErickFinancas\Plugins\Routeplugin;
use ErickFinancas\Plugins\ViewPlugin;
use ErickFinancas\ServiceContainer;


require_once __DIR__ .'/../vendor/autoload.php';

$serviceContainer = new ServiceContainer();

$app = new Application($serviceContainer);

//integrar com Aura/Router
$app->plugin(new Routeplugin());
$app->plugin(new ViewPlugin());
$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

//rota sem parametros
//$app->get('/', function (RequestInterface $request) use ($app) {
//    $view = $app->service('view.renderer');
//    return $view->render('test.html.twig', ['name' => 'Erick Soares']);
//});

// $app->get('/{name}', function (ServerRequestInterface $request) use ($app) {
//     $view = $app->service('view.renderer');
//     return $view->render('test.html.twig', ['name' => $request->getAttribute('name')]);
// });

//trabalhando com parametros ServerRequestInterface. Se for sem parametros apenas RequestInterface
// $app->get('/home/{name}', function (ServerRequestInterface $request) {
//     $response = new Response();
//     $response->getBody()->write("response com emitter do diactoros");
//     return $response;
// });

require_once __DIR__ . '/../src/controllers/category-costs.php';
require_once __DIR__ . '/../src/controllers/users.php';
require_once __DIR__ . '/../src/controllers/auth.php';

//chamada da execução da aplicação
$app->start();