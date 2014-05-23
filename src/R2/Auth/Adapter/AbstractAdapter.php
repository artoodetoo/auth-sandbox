<?php

namespace R2\Auth\Adapter;

use R2\Auth\Entity\User;
use R2\Auth\Exception;
use R2\Auth\Storage\StorageInterface;
use R2\Auth\Util;

abstract class AbstractAdapter implements AdapterInterface
{
    public $providerId = null;
    public $config = null;
    public $params = null;
    public $endpoint = null;
    public $user = null;
    public $api = null;
    protected $authConfig = null;
    protected $storage = null;

    /**
     * common providers adapter constructor
     */
    public function __construct($providerId, $authConfig, $config, $params, StorageInterface $storage)
    {
        $this->providerId = $providerId;
        $this->config     = $config;
        $this->authConfig = $authConfig;
        $this->params     = $params;
        $this->storage    = $storage;

        $this->endpoint = $this->storage->get("{$providerId}.hauth_endpoint");

        // new user instance
        $this->user = new User();
        $this->user->providerId = $providerId;

        // initialize the current provider adapter
        $this->initialize();
    }

    public function authenticate(array $parameters = [])
    {
        if ($this->isAuthorized()) {
            return $this;
        }

        foreach (array_keys($this->authConfig['providers']) as $idpid) {
            $this->storage->delete("{$idpid}.hauth_return_to");
            $this->storage->delete("{$idpid}.hauth_endpoint");
            $this->storage->delete("{$idpid}.id_provider_params");
        }

        $this->storage->deleteMatch("{$this->providerId}.");

        $baseUrl = $this->authConfig['base_url'];

        $defaults = array(
            'hauth_return_to' => Util::getCurrentUrl(),
            'hauth_endpoint'  =>
                $baseUrl.(strpos($baseUrl, '?') ? '&' : '?')."hauth.done={$this->providerId}",
            'hauth_start_url' =>
                $baseUrl.(strpos($baseUrl, '?') ? '&' : '?')."hauth.start={$this->providerId}&hauth.time=".time(),
        );

        $parameters = array_merge($defaults, (array)$parameters);

        $this->storage->set($this->providerId . ".hauth_return_to", $parameters["hauth_return_to"]);
        $this->storage->set($this->providerId . ".hauth_endpoint", $parameters["hauth_endpoint"]);
        $this->storage->set($this->providerId . ".id_provider_params", $parameters);

        // redirect user to start url
        Util::redirect($parameters["hauth_start_url"]);
    }

    /**
     * IDp wrappers initializer
     *
     * The main job of wrappers initializer is to performs (depend on the IDp api client it self):
     *     - include some libs needed by this provider,
     *     - check IDp key and secret,
     *     - set some needed parameters (stored in $this->params) by this IDp api client
     *     - create and setup an instance of the IDp api client on $this->api
     */
    abstract public function initialize();

    /**
     * Begin login
     */
    abstract public function loginBegin();

    /**
     * Finish login
     */
    abstract public function loginFinish();

    /**
     * Generic logout
     */
    public function logout()
    {
        $this->clearTokens();

        return true;
    }

    /**
     * Grab the user profile from the IDp api client
     */
    public function getUserProfile()
    {
        throw new Exception("Provider does not support this feature.", 8);
    }

    /**
     * load the current logged in user contacts list from the IDp api client
     */
    public function getUserContacts()
    {
        throw new Exception("Provider does not support this feature.", 8);
    }

    /**
     * Return the user activity stream
     */
    public function getUserActivity($stream)
    {
        throw new Exception("Provider does not support this feature.", 8);
    }

    /**
     * Return the user activity stream
     */
    public function setUserStatus($status)
    {
        throw new Exception("Provider does not support this feature.", 8);
    }

    /**
     * Return true if the user is connected to the current provider
     */
    public function isAuthorized()
    {
        return (bool) $this->storage->get("{$this->providerId}.is_logged_in");
    }

    /**
     * Set user to connected
     */
    public function setUserConnected()
    {
        $this->storage->set("{$this->providerId}.is_logged_in", 1);
    }

    /**
     * Set user to unconnected
     */
    public function setUserUnconnected()
    {
        $this->storage->set("{$this->providerId}.is_logged_in", 0);
    }

    /**
     * Get or set a token
     */
    public function token($token, $value = null)
    {
        if ($value === null) {
            return $this->storage->get("{$this->providerId}.token.$token");
        } else {
            $this->storage->set("{$this->providerId}.token.$token", $value);
        }
    }

    /**
     * Delete a stored token
     */
    public function deleteToken($token)
    {
        $this->storage->delete("{$this->providerId}.token.$token");
    }

    /**
     * Clear all existent tokens for this provider
     */
    public function clearTokens()
    {
        $this->storage->deleteMatch("{$this->providerId}.");
    }
}
