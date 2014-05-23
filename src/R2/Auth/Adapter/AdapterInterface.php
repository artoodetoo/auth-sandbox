<?php

namespace R2\Auth\Adapter;

interface AdapterInterface
{
    public function initialize();
    public function loginBegin();
    public function loginFinish();
    public function authenticate(array $parameters = []);
    public function logout();
    public function isAuthorized();
}
