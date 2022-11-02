<?php

namespace App\Controller;

use App\Entity\User;
use Core\BaseController;
use App\Util\{
    Session,
    Request,
    Auth
} ;

class DefaultController extends BaseController {

    /**
     * Login: Processes a login request. NOTE: This controller can only be
     * accessed by unauthenticated users!
     * @return mixed
     *
     */
    public function login(): mixed {

        Auth::checkUnauthenticated();

        $error_login = '';
        if (Request::exists() && Request::post("login")) {
            $username = Request::post("username");
            $passwd = Request::post("passwd");
            $user = $this->userRepository->findByUsername($username);

            if (is_object($user)) {
                if (\password_verify($passwd, $user->getPassword())):
                    Session::put('auth', $user->getId());
                    $this->redirect->to("chat.index");
                else:
                    $error_login = 'Mot de passe incorrect';
                endif;
            } else {
                if (!is_null(Request::post('username')) && !is_null(Request::post('passwd'))) {
                    
                    $user = new User([
                        "name" => Request::post('username'),
                        "password" => password_hash(Request::post('passwd'), PASSWORD_BCRYPT),
                        "username" => Request::post('username'),
                    ]);

                    $this->userRepository->add($user);
                    Session::put('auth', $user->getId());
                    $this->redirect->to("chat.index");
                }
            }
        }

        return $this->render('login/index.html.twig',["error_login" => $error_login]);
    }

}
