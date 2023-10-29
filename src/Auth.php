<?php

namespace App;

use App\Exception\Security\ForbiddenException;
use App\Exception\AlreadyLoggedException;


class Auth
{
    // This function checks if the user can access the page or not
    public static function checkAccess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['auth'])) {
            throw new ForbiddenException();
        }
    }

    // This function checks if the user is already logged
    public static function checkAlreadyLogged()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['auth'])) {
            throw new AlreadyLoggedException();
        }
    }
}
