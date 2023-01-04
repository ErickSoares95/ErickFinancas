<?php

namespace ErickFinancas\Plugins;


use ErickFinancas\ServiceContainerInterface;
interface PluginInterface
{
    public function Register(ServiceContainerInterface $container);
}