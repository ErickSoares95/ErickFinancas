<?php

namespace ErickFinancas;
use Xtreamwayz\Pimple\Container;

class ServiceContainer implements ServiceContainerInterface
{

    private $container;

    public function __construct()
    {
        $this->container = new Container();
    }

	/**
	 * @param string $name
	 * @param mixed $service
	 * @return mixed
	 */
	public function add(string $name, $service) 
    {
        $this->container[$name] = $service;
	}
	
	/**
	 *
	 * @param string $name
	 * @param Closure $callable
	 * @return mixed
     * Produz o serviço de acordo com a função que for passada no callable
	 */
	public function addLazy(string $name, callable $callable) 
    {
        $this->container[$name] = $this->container->factory($callable);
	}
	
	/**
	 *
	 * @param string $name
	 * @return mixed
     * sabe diferenciar se é o add ou lazy
	 */
	public function get(string $name) 
    {
        return $this->container->get($name);
	}
	
	/**
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function has(string $name) 
    {
        return $this->container->has($name);
	}
}