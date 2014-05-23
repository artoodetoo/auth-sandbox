<?php

namespace Examples\Signup;

class Base
{
    /** @staticvar array Configuration */
    protected static $config = [];
    /** @staticvar Examples\Signup\Mysqli DBAL Interface */
    protected static $db = null;
    
    public function redirect($uri)
    {
        header("Location: index.php?route={$uri}");
        die();
    }
    
    public function render($view, array $data = [])
    {
        if (!empty($data)) {
            extract($data, EXTR_PREFIX_SAME, 'wddx');
        }
        
        require(__DIR__.'/views/'.$view.'.html.php');
    }
    
    public function collectPostForm($names)
    {
        $defaults = array_fill_keys($names, '');
        $result = array_intersect_key($_POST, $defaults) + $defaults;
        array_walk_recursive(
            $result,
            function (&$item, $key) {
                $item = trim($item);
            }
        );

        return $result;
    }
    
    protected function e($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}
