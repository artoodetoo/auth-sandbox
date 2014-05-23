<?php

namespace R2\Auth\Storage;

/**
 * Storage manager interface
 */
interface StorageInterface
{
    public function config($key, $value = null);
    public function get($key);
    public function set($key, $value);
    public function delete($key);
    public function deleteMatch($key);
}
