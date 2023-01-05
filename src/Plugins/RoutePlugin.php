<?php
declare(strict_types=1);

namespace ErickFinancas\Plugins;

use Aura\Router\RouterContainer;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use ErickFinancas\ServiceContainerInterface;
use Zend\Diactoros\ServerRequestFactory;

class RoutePlugin implements PluginInterface
{
    
	/**
	 * @param \ErickFinancas\ServiceContainerInterface $container
	 * @return mixed
	 */
	public function Register(ServiceContainerInterface $container) 
	{
		$routeContainer = new RouterContainer();
		//registrar as rotas da aplicação
		$map = $routeContainer->getMap();
		//Tem a função de identificar a rota que está sendo acessada
		$matcher = $routeContainer->getMatcher();
		//Tem a função de gerar links dcom base nas rotas registradas
		$generator = $routeContainer->getGenerator();
		$request = $this->getRequest();

		//Adicionando os novos serviços
		$container->add('routing', $map);
		$container->add('routing.matcher', $matcher); //combinador que gera a rota que foi acessada
		$container->add('routing.generator', $generator);
		$container->add(RequestInterface::class, $request);

		$container->addLazy('route', function (ContainerInterface $container) {
			$matcher = $container->get('routing.matcher');
			$request = $container->get(RequestInterface::class);
			return $matcher->match($request);
		});
	}

	protected function getRequest() : RequestInterface
	{
		return ServerRequestFactory::fromGlobals(
			$_SERVER,
			$_GET,
			$_POST,
			$_COOKIE,
			$_FILES
		);
	}

}