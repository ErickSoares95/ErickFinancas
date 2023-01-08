<?php
declare(strict_types=1);

namespace ErickFinancas\Plugins;

use ErickFinancas\Repository\RepositoryFactory;
use ErickFinancas\ServiceContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class DbPlugin implements PluginInterface
{
    
	/**
	 * @param \ErickFinancas\ServiceContainerInterface $container
	 * @return mixed
	 */
    public function Register(ServiceContainerInterface $container)
    {
        $capsule = new Capsule();
        $config = include __DIR__ . '/../../config/db.php';
        $capsule->addConnection($config['development']);
        //inicia o banco de dados
        $capsule->bootEloquent();

        $container->add('repository.factory', new RepositoryFactory());

    }

}