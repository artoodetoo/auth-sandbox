<?php

namespace R2\Auth\Entity;

class Profile
{
    /* The Unique user's ID on the connected provider */

    public $identifier = null;

    /* User website, blog, web page */
    public $webSiteURL = null;

    /* URL link to profile page on the IDp web site */
    public $profileURL = null;

    /* URL link to user photo or avatar */
    public $photoURL = null;

    /* User displayName provided by the IDp or a concatenation of first and last name. */
    public $displayName = null;

    /* A short about_me */
    public $description = null;

    /* User's first name */
    public $firstName = null;

    /* User's last name */
    public $lastName = null;

    /* male or female */
    public $gender = null;

    /* language */
    public $language = null;

    /* User age, we don't calculate it. we return it as is if the IDp provide it. */
    public $age = null;

    /* User birth Day */
    public $birthDay = null;

    /* User birth Month */
    public $birthMonth = null;

    /* User birth Year */
    public $birthYear = null;

    /* User email. Note: not all of IDp grant access to the user email */
    public $email = null;

    /* Verified user email. Note: not all of IDp grant access to verified user email */
    public $emailVerified = null;

    /* phone number */
    public $phone = null;

    /* complete user address */
    public $address = null;

    /* user country */
    public $country = null;

    /* region */
    public $region = null;

    /** city */
    public $city = null;

    /* Postal code  */
    public $zip = null;

}
