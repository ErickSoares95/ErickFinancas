<?php 
use ErickFinancas\Application;
use ErickFinancas\Plugins\AuthPlugin;
use ErickFinancas\Plugins\DbPlugin;
use ErickFinancas\ServiceContainer;

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

//integrar com Aura/Router
$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

return $app;