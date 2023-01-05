<?php
declare(strict_types=1);
namespace ErickFinancas;

use ErickFinancas\Plugins\PluginInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\SapiEmitter;

class Application
{
    private $serviceContainer;

    public function __construct(ServiceContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    //pegar um serviço
    public function Service($name){
        return $this->serviceContainer->get($name);
    }

    //adicionar um novo servico usado nos plugin
    public function addService(string $name, $service) : void
    {
        if (is_callable($service)) {
            $this->serviceContainer->addLazy($name, $service);
        }else {
            $this->serviceContainer->add($name, $service);
        }
    }

    public function plugin(PluginInterface $plugin) : void
    {
        $plugin->register($this->serviceContainer);
    }

    
    public function get($path, $action, $name = null) : Application
    {
        $routing = $this->Service("routing");
        $routing->get($name, $path, $action);
        return $this;
    }

    public function start()
    {
        $route = $this->service('route');
        /** @var *ServerRequestInterface $request */
        //request para utilizar parametros nas rotas
        $request = $this->service(RequestInterface::class);

        if (!$route) {
            echo "Page not found";
            exit;
        }

        //configuração para pegar atributos e colocar na requisição
        foreach ($route->attributes as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }

        //ação da rota configurtada
        $callable = $route->handler;
        //chamar a resposta e emitir
        $reponse = $callable($request);
        $this->emitReponse($reponse);
    }

    //trabalhar com repostaras psr7
    protected function emitReponse(ResponseInterface $response){
        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }

}