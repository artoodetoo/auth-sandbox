<?php

namespace R2\Auth;

class Util
{

    /**
     * Redirects to a given URL.
     * 
     * @param string $url
     */
    public static function redirect($url)
    {
        header("Location: $url");
        die();
    }

    /**
     * Exits with 404 error and custom message text.
     * 
     * @param string $message
     */
    public function error404($message = 'Page not found')
    {
        header('HTTP/1.0 404 Not Found');
        die($message);
    }
    
    /**
     * Returns the Current URL.
     * 
     * @return string
     */
    public static function getCurrentUrl()
    {
        $protocol = 'http';

        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            if ($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
                $protocol = 'https';
            }
        } elseif (isset($_SERVER['HTTPS']) && ( $_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] == 1 )) {
            $protocol = 'https';
        } elseif (isset($_SERVER['SERVER_PORT']) && ( $_SERVER['SERVER_PORT'] === '443' )) {
            $protocol = 'https';
        }

        $protocol .= '://';
        $host = $_SERVER['HTTP_HOST'];

        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        }

        $currentUrl = $protocol . $host . $_SERVER['REQUEST_URI'];
        $parts = parse_url($currentUrl);

        $query = '';
        if (!empty($parts['query'])) {
            $params = explode('&', $parts['query']);

            if (!empty($params)) {
                $query = '?' . implode($params, '&');
            }
        }

        // use port if non default
        $port = isset($parts['port']) &&
                (($protocol === 'http://' && $parts['port'] !== 80) ||
                ($protocol === 'https://' && $parts['port'] !== 443)) ? ':' . $parts['port'] : '';

        // rebuild
        return $protocol . $parts['host'] . $port . $parts['path'] . $query;
    }
}
