<?php

namespace R2\Auth\Storage;

use R2\Auth\Exception;
use R2\Auth\Storage\StorageInterface;

/**
 * Session storage manager
 */
class Session implements StorageInterface
{

    public function __construct()
    {
        if (!session_id()) {
            if (!session_start()) {
                throw new Exception('Auth requires the use of session_start()');
            }
        }
    }

    public function config($key, $value = null)
    {
        $key = strtolower($key);

        if ($value) {
            $_SESSION['HA::CONFIG'][$key] = serialize($value);
        } elseif (isset($_SESSION ['HA::CONFIG'][$key])) {
            return unserialize($_SESSION ['HA::CONFIG'][$key]);
        }

        return null;
    }

    public function get($key)
    {
        $key = 'hauth_session.' . strtolower($key);

        if (isset($_SESSION['HA::STORE'], $_SESSION ['HA::STORE'] [$key])) {
            return unserialize($_SESSION['HA::STORE'][$key]);
        }

        return null;
    }

    public function set($key, $value)
    {
        $key = 'hauth_session.' . strtolower($key);

        $_SESSION['HA::STORE'][$key] = serialize($value);
    }

    public function delete($key)
    {
        $key = 'hauth_session.' . strtolower($key);

        if (isset($_SESSION ['HA::STORE'], $_SESSION['HA::STORE'][$key])) {
            $f = $_SESSION ['HA::STORE'];

            unset($f [$key]);

            $_SESSION['HA::STORE'] = $f;
        }
    }

    public function deleteMatch($key)
    {
        $key = 'hauth_session.' . strtolower($key);

        if (isset($_SESSION['HA::STORE']) && count($_SESSION ['HA::STORE'])) {
            $f = $_SESSION['HA::STORE'];

            foreach ($f as $k => $v) {
                if (strstr($k, $key)) {
                    unset($f[$k]);
                }
            }

            $_SESSION['HA::STORE'] = $f;
        }
    }
}
