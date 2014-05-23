<?php

namespace R2\Auth\Adapter;

use R2\Auth\Exception;
use R2\Auth\Storage\StorageInterface;

/**
 * Auth will automatically load AdapterFactory and create
 * an instance of it for each authenticated provider.
 */
class AdapterFactory
{
    protected $authConfig = null;
    protected $storage = null;

    public function __construct(array $authConfig, StorageInterface $storage = null)
    {
        $this->authConfig = $authConfig;
        $this->storage    = $storage;
    }

    /**
     * Creates a new adapter.
     *
     * @param string  $id      The id or name of the IDp
     * @param array   $params  (optional) required parameters by the adapter
     */
    public function factory($id, $params = null)
    {
        $id = $this->getProviderCiId($id);
        $config = $this->getConfigById($id);

        if (!$this->authConfig) {
            throw new Exception("Unknown Provider", Exception::UNKNOWN_OR_DISABLED_PROVIDER);
        }

        if (!(bool)$config["enabled"]) {
            throw new Exception("Provider disabled", Exception::UNKNOWN_OR_DISABLED_PROVIDER);
        }

        $providerClassName = "R2\\Auth\\Provider\\{$id}";

        // Is wrapper defined?
        if (isset($config["wrapper"]) && $config["wrapper"]) {
            $providerClassName = $config ["wrapper"] ["class"];
        }

        // Create the adapter instance
        return new $providerClassName(
            $id,
            $this->authConfig,
            $config,
            $params,
            $this->storage
        );
    }

    /**
     * Setup an adapter for a given provider.
     * 
     * @param string $providerId
     * @param array  $parameters
     * 
     * @return type
     */
    public function setup($providerId, array $parameters = [])
    {
        if (!$parameters) {
            $parameters = $this->storage->get($providerId.'.id_provider_params');
        }

        return $this->factory($providerId, $parameters);
    }
    
    /**
     * Gets the provider config by id.
     */
    private function getConfigById($id)
    {
        if (isset($this->authConfig["providers"][$id])) {
            return $this->authConfig["providers"][$id];
        }

        return null;
    }

    /**
     * return the provider config by id; insensitive
     */
    private function getProviderCiId($id)
    {
        foreach (array_keys($this->authConfig["providers"]) as $idpid) {
            if (strtolower($idpid) == strtolower($id)) {
                return $idpid;
            }
        }

        return null;
    }
}
