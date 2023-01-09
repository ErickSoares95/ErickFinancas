<?php
declare(strict_types=1);

namespace ErickFinancas\Plugins;

use ErickFinancas\Models\CategoryCost;
use ErickFinancas\Models\User;
use ErickFinancas\Repository\RepositoryFactory;
use ErickFinancas\ServiceContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Interop\Container\ContainerInterface;

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

        $container->addLazy('category-cost.repository', function(ContainerInterface $container){
            return $container->get('repository.factory')->factory(CategoryCost::class);
        });

        $container->addLazy('user.repository', function(ContainerInterface $container){
            return $container->get('repository.factory')->factory(User::class);
        });

    }

}