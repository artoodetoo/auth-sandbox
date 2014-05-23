<?php

namespace R2\Auth;

use R2\Auth\Exception;
use R2\Auth\Storage\StorageInterface;
use R2\Auth\Adapter\AdapterFactory;

/**
 * Auth class provides a simple way to authenticate users via OpenID and OAuth.
 * Generally, Auth is the only class you should instanciate and use throughout your application.
 */
class Auth
{

    public $config  = [];
    public $storage = null;

    /**
     * Initialize Auth
     */
    public function __construct(array $config, StorageInterface $storage)
    {
        // reset debug mode
        if (!isset($config["debug_mode"])) {
            $config["debug_mode"] = false;
            $config["debug_file"] = null;
        }

        
        $this->config = $config;
        $this->storage = $storage;

        if ($this->storage->get('error.status')) {
            $e = $this->storage->get('error.exception');
            $m = $this->storage->get('error.message');
            $c = $this->storage->get('error.code');
            $this->storage->deleteMatch('error.');

            if ($e) {
                throw $e;
            }

            throw new Exception($m, $c);
        }
    }

    /**
     * Returns the adapter instance for an authenticated provider.
     * 
     * @param string $providerId
     * 
     * @return R2\Auth\Adapter\AdapterInterface
     */
    public function getAdapter($providerId)
    {
        $adapterFactory = new AdapterFactory($this->config, $this->storage);

        return $adapterFactory->setup($providerId);
    }

    /**
     * Checks if the current user is connected to a given provider
     * 
     * @return Boolean
     */
    public function isConnectedWith($providerId)
    {
        return (bool)$this->storage->get("{$providerId}.is_logged_in");
    }

    /**
     * Gets all authenticated providers.
     * 
     * @return array
     */
    public function getConnectedProviders()
    {
        $idps = [];
        foreach ($this->config["providers"] as $idpid => $params) {
            if ($this->isConnectedWith($idpid)) {
                $idps[] = $idpid;
            }
        }

        return $idps;
    }

    /**
     * Gets enabled providers as well as a flag if you are connected.
     * 
     * @return array
     */
    public function getProviders()
    {
        $idps = [];
        foreach ($this->config["providers"] as $idpid => $params) {
            if ($params['enabled']) {
                $idps[$idpid] = ['connected' => false];

                if ($this->isConnectedWith($idpid)) {
                    $idps[$idpid]['connected'] = true;
                }
            }
        }

        return $idps;
    }

    /**
     * Logout all connected provider at once.
     */
    public function logoutAllProviders()
    {
        $idps = $this->getConnectedProviders();
        foreach ($idps as $idp) {
            $adapter = $this->getAdapter($idp);
            $adapter->logout();
        }
    }
}
