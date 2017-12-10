<?php
namespace ExpressiveProvider;

use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;

abstract class BaseProvider
{
    /**
     * @var array
     */
    private $providerArray = [];

    public function __invoke()
    {
        $this->register();
        return $this->providerArray;
    }

    /**
     * Register all providers
     */
    abstract protected function register() : void;

    /**
     * @param string $contract
     * @param null $service
     * @return mixed
     */
    protected function invokables(string $contract, $service)
    {
        return $this->addToDependencies('invokables', $contract, $service);
    }

    /**
     * @param string $contract
     * @param null $service
     * @return mixed
     */
    protected function factory(string $contract, $service)
    {
        return $this->addToDependencies('factories', $contract, $service);
    }

    /**
     * @param string $name
     * @param null $service
     * @return mixed
     */
    protected function aliases(string $name, $service)
    {
        return $this->addToDependencies('aliases', $name, $service);
    }

    /**
     * @param string $name
     * @param null $configs
     * @return \Closure|null
     */
    protected function config(string $name, $configs)
    {
        $this->providerArray[$name] = $configs;
    }

    /**
     * @param string $contract
     * @param $service
     */
    protected function abstractService(string $contract, $service)
    {
        if (is_string($service)) {
            $service = [$service];
        }
        $this->providerArray[ConfigAbstractFactory::class][$contract] = $service;
    }

    /**
     * @param string $namespace
     * @param string $serviceName
     * @param null $service
     * @return \Closure|null
     */
    private function addToDependencies(string $namespace, string $serviceName, $service)
    {
        $this->providerArray['dependencies'][$namespace][$serviceName] = $service;
    }
}
