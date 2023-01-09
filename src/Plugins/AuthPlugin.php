<?php
declare(strict_types=1);

namespace ErickFinancas\Plugins;

use ErickFinancas\Auth\Auth;
use ErickFinancas\Auth\JasnyAuth;
use ErickFinancas\ServiceContainerInterface;
use Interop\Container\ContainerInterface;

class AuthPlugin implements PluginInterface
{
    
	/**
	 * @param \ErickFinancas\ServiceContainerInterface $container
	 * @return mixed
	 */
    public function Register(ServiceContainerInterface $container)
    {
        $container->addLazy('jasny.auth', function (ContainerInterface $container){
            return new JasnyAuth($container->get('user.repository'));
        });
        $container->addLazy('auth', function(ContainerInterface $container){
            return new Auth($container->get('jasny.auth'));
        });

    }

}