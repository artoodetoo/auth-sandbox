<?php

namespace R2\Auth;

class Exception extends \Exception
{
    const UNSPECIFIED_ERROR                = 0;
    const HYBRIAUTH_CONFIGURATION_ERROR    = 1;
    const PROVIDER_NOT_PROPERLY_CONFIGURED = 2;
    const UNKNOWN_OR_DISABLED_PROVIDER     = 3;
    const MISSING_APPLICATION_CREDENTIALS  = 4;
    const AUTHENTIFICATION_FAILED          = 5;
    const USER_PROFILE_REQUEST_FAILED      = 6;
    const USER_NOT_CONNECTED               = 7;
    const UNSUPPORTED_FEATURE              = 8;
    const USER_CONTACTS_REQUEST_FAILED     = 9;
    const USER_UPDATE_STATUS_FAILED        = 10;
}
