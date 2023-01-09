<?php
declare(strict_types=1);

namespace ErickFinancas\Plugins;

use ErickFinancas\View\Twig\TwigGlobals;
use ErickFinancas\View\ViewRenderer;
use Interop\Container\ContainerInterface;
use ErickFinancas\ServiceContainerInterface;

class ViewPlugin implements PluginInterface
{
    
	/**
	 * @param \ErickFinancas\ServiceContainerInterface $container
	 * @return mixed
	 */
    public function Register(ServiceContainerInterface $container)
    {
        $container->addLazy('twig', function (ContainerInterface $container) {
            //carregador
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../templates');
            //carregar os templates
            $twig = new \Twig_Environment($loader);

            //adicionando a sessão
            $auth = $container->get('auth');

            //gerar as rotas com parametros no twig
            $generator = $container->get('routing.generator');
            //extensão gerada para armazenar sessão
            $twig->addExtension(new TwigGlobals($auth));
            $twig->addFunction(new \Twig_SimpleFunction('route',
            function(string $name, array $params = []) use($generator){
                return $generator->generate($name,$params);
            }));    
            return $twig;
        });

        $container->addLazy('view.renderer', function (ContainerInterface $container) {
            $twigEnviroment = $container->get('twig');
            return new ViewRenderer($twigEnviroment);
        });
    }

}