<?php

namespace R2\Auth\Entity;

class Activity
{
    /* activity id on the provider side, usually given as integer */

    public $id = null;

    /* activity date of creation */
    public $date = null;

    /* activity content as a string */
    public $text = null;

    /* user who created the activity */
    public $user = null;

    public function __construct()
    {
        $this->user = new \stdClass();

        // typically, we should have a few information about the user who created the event from social apis
        $this->user->identifier = null;
        $this->user->displayName = null;
        $this->user->profileURL = null;
        $this->user->photoURL = null;
    }

}
