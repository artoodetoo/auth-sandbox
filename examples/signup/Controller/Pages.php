<?php

namespace Examples\Signup\Controller;

use Examples\Signup\Base;

class Pages extends Base
{
    public function help()
    {
        $this->loadView('pages/help');
    }

    public function error()
    {
        $this->loadView('pages/error');
    }
}
