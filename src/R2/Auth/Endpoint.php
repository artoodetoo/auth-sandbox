<?php

namespace R2\Auth;

use R2\Auth\Adapter\AdapterFactory;
use R2\Auth\Storage\StorageInterface;
use R2\Auth\Util;

/**
 * Endpoint class.
 * Provides a simple way to handle the OpenID and OAuth endpoint.
 */
class Endpoint
{

    protected $request = null;
    protected $config  = null;
    protected $storage = null;

    public function __construct(array $config, StorageInterface $storage)
    {
        $this->config = $config;
        $this->storage = $storage;
    }

    /**
     * Process the current request
     */
    public function process()
    {
        // Fix a strange behavior when some provider call back ha endpoint
        // with /index.php?hauth.done={provider}?{args}...
        // >here we need to recreate the $_REQUEST
        if (strrpos($_SERVER['QUERY_STRING'], '?')) {
            $_SERVER['QUERY_STRING'] = str_replace('?', '&', $_SERVER['QUERY_STRING']);
            parse_str($_SERVER['QUERY_STRING'], $_REQUEST);
        }
        // If we get a hauth.start
        if (isset($_REQUEST['hauth_start']) && $_REQUEST['hauth_start']) {
            $this->processAuthStart(trim(strip_tags($_REQUEST['hauth_start'])));
        // Else if hauth.done
        } elseif (isset($_REQUEST['hauth_done']) && $_REQUEST['hauth_done']) {
            $this->processAuthDone(trim(strip_tags($_REQUEST['hauth_done'])));
        }
    }

    private function processAuthStart($providerId)
    {
        // Check if page accessed directly
        if (!$this->storage->get("{$providerId}.hauth_endpoint")) {
            header('HTTP/1.0 404 Not Found');
            die('You cannot access this page directly.');
        }

        $adapterFactory = new AdapterFactory($this->config, $this->storage);
        $adapter = $adapterFactory->setup($providerId);

        // if REQUESTed hauth_idprovider is wrong, session not created, etc.
        if (!$adapter) {
            Util::error404('Invalid parameter! Please return to the login page and try again.');
        }

        try {
            $adapter->loginBegin();
        } catch (\Exception $e) {
            $this->storage->set('error.status', 1);
            $this->storage->set('error.message', $e->getMessage());
            $this->storage->set('error.code', $e->getCode());
            $this->storage->set('error.exception', $e);

            $adapter->returnToCallbackUrl(returnToCallbackUrl);
        }

        die();
    }

    private function processAuthDone($providerId)
    {
        $adapterFactory = new AdapterFactory($this->config, $this->storage);
        $adapter = $adapterFactory->setup($providerId);

        if (!$adapter) {
            $adapter->setUserUnconnected();

            Util::error404('Invalid parameter! Please return to the login page and try again.');
        }

        try {
            $adapter->loginFinish();
        } catch (\Exception $e) {
            $this->storage->set('error.status', 1);
            $this->storage->set('error.message', $e->getMessage());
            $this->storage->set('error.code', $e->getCode());
            $this->storage->set('error.exception', $e);

            $adapter->setUserUnconnected();
        }

        $this->returnToCallbackUrl($providerId);
    }
    
    /**
    * Redirect the user to hauth_return_to (the callback url)
    */
    private function returnToCallbackUrl($providerId)
    {
        $callbackUrl = $this->storage->get("{$providerId}.hauth_return_to");

        $this->storage->delete("{$providerId}.hauth_return_to");
        $this->storage->delete("{$providerId}.hauth_endpoint");
        $this->storage->delete("{$providerId}.id_provider_params");

        Util::redirect($callbackUrl);
    }
}
