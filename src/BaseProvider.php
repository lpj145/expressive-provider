<?php
namespace ExpressiveProvider;

use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;

abstract class BaseProvider
{
    /**
     * @var array
     */
    private $providerArray = [];
    /**
     * @var array
     */
    protected $providers = [];

    public function __invoke()
    {
        $this->register();
        $this->joinAllProviders();
        return $this->providerArray;
    }

    /**
     * Register all providers
     */
    abstract protected function register() : void;

    /**
     * @param string $contract
     * @param null $service
     */
    protected function invokables(string $contract, $service)
    {
        $this->addToDependencies('invokables', $contract, $service);
    }

    /**
     * @param string $contract
     * @param null $service
     */
    protected function factory(string $contract, $service)
    {
        $this->addToDependencies('factories', $contract, $service);
    }

    /**
     * @param string $name
     * @param null $service
     */
    protected function aliases(string $name, $service)
    {
        $this->addToDependencies('aliases', $name, $service);
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
     */
    private function addToDependencies(string $namespace, string $serviceName, $service)
    {
        $this->providerArray['dependencies'][$namespace][$serviceName] = $service;
    }

    /**
     * Join all providers on only provider
     */
    private function joinAllProviders()
    {
        if (count($this->providers) === 0) {
            return;
        }

        foreach ($this->providers as $provider) {
            $this->providerArray = array_merge_recursive($this->providerArray, $provider);
        }
    }
}
