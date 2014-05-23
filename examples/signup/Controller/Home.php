<?php

namespace Examples\Signup\Controller;

use Examples\Signup\Base;

class Home extends Base
{
    public function index()
    {
        $this->redirect('users/login');
    }
}
