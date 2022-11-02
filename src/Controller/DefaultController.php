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
    public function login():mixed{

        Auth::checkUnauthenticated();

        $error_login = '';
        $error_subscribe = '';

        if (Request::exists() && Request::post("login")) {

            $username = Request::post("username");
            $passwd = Request::post("passwd");
            $user = $this->userRepository->findByUsername($username);

            if (is_object($user)) {
                if (\password_verify($passwd, $user->getPassword())) {
                    Session::put('auth', $user->getId());
                    $this->redirect->to("chat.index");
                } else {
                    $error_login = 'Mot de passe incorrect';
                }
            } else {

                if (!is_null($_POST['username']) && !is_null($_POST['passwd'])) {
                    $user = new User([
                        "name" => $_POST['username'],
                        "password" => password_hash($_POST['passwd'], PASSWORD_BCRYPT),
                        "username" => $_POST['username'],
                    ]);

                    $this->userRepository->add($user);
                    Session::put('auth', $user->getId());
                    $this->redirect->to("chat.index");
                }
            }
        }

        return $this->render(
                'login/index.html.twig',
                ["error_login" => $error_login, "error_subscribe" => $error_subscribe]
        );
    }

}
