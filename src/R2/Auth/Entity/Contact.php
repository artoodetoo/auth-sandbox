<?php

namespace R2\Auth\Entity;

class Contact
{
    /* The Unique contact user ID */

    public $identifier = null;

    /* User website, blog, web page */
    public $webSiteURL = null;

    /* URL link to profile page on the IDp web site */
    public $profileURL = null;

    /* URL link to user photo or avatar */
    public $photoURL = null;

    /* User displayName provided by the IDp or a concatenation of first and last name */
    public $displayName = null;

    /* A short about_me */
    public $description = null;

    /* User email. Not all of IDp grant access to the user email */
    public $email = null;

}
