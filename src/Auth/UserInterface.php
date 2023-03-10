<?php
declare(strict_types=1);

namespace ErickFinancas\Plugins;


use Interop\Container\ContainerInterface;
use ErickFinancas\Auth\Auth;
use ErickFinancas\Auth\JasnyAuth;
use ErickFinancas\ServiceContainerInterface;

class AuthPlugin implements PluginInterface
{

    public function register(ServiceContainerInterface $container)
    {
        $container->addLazy('jasny.auth', function (ContainerInterface $container) {
            return new JasnyAuth($container->get('user.repository'));
        });
        $container->addLazy('auth', function (ContainerInterface $container) {
            return new Auth($container->get('jasny.auth'));
        });

    }
}