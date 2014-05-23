<?php

namespace R2\Auth\Entity;

use R2\Auth\Entity\Profile;

class User
{
    /* The ID (name) of the connected provider */

    public $providerId = null;

    /* timestamp connection to the provider */
    public $timestamp = null;

    /* user profile, contains the list of fields available in the normalized user profile structure used by Auth. */
    public $profile = null;

    /**
     * initialize the user object.
     */
    public function __construct()
    {
        $this->timestamp = time();

        $this->profile = new Profile();
    }

}
