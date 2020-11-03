<?php

namespace App\Util;

/**
 * Description of Auth
 *
 * @author hamdi
 */
class Auth {

    /**
     * Check Authenticated: Checks to see if the user is authenticated,
     * destroying the session and redirecting to a specific location if the user
     * session doesn't exist.
     * @access public
     * @param string $redirect
     * @since 1.0.2
     */
    public static function checkAuthenticated($redirect = "default.login"): void {
        Session::init();
        if (!Session::exists("auth")) {
            Session::destroy();
            Redirect::to($redirect);
        }
    }

    /**
     * Check Unauthenticated: Checks to see if the user is unauthenticated,
     * redirecting to a specific location if the user session exist.
     * @access public
     * @param string $redirect
     * @since 1.0.2
     */
    public static function checkUnauthenticated($redirect = "chat.index") {
        Session::init();
        if (Session::exists("auth")) {
            (new Redirect())->to($redirect);
        }
    }

}
