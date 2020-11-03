<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Auth as Connexion;
use Core\BaseController;
use App\Util\{
    Session,
    Request
};

class ChatController extends BaseController {

    public function __construct() {

        parent::__construct();
        if (!Session::exists("auth")) {
            $this->redirect->to("default.login");
        }
    }

    /**
     * IndexAction 
     */
    public function index() {

        if (Request::exists("post")) {
            $message = new Message([
                "content" => Request::post("content"),
                "userId" => Session::get("auth")
            ]);
            $this->messageRepository->add($message);
        }
        // Render page index
        echo $this->twig->render('home/index.html.twig');
    }

    /**
     * Refresh Action
     */
    public function refresh() {

        $response = [];
        $messages = $this->messageRepository->findAll();

        foreach ($messages as $message) {

            $user = $this->userRepository->find(intval($message->getUserid()));
            if (is_object($user)):
                $response[$message->getId()]['content'] = $message->getContent();
                $response[$message->getId()]['user'] = $user->getName();
                $response[$message->getId()]['datetime'] = $message->getCreatedAt();
            endif;
        }

        echo json_encode($response);
    }

    public function checkConnection() {

        $connexions = $this->authRepository->findAll();
        $connectedUsers = [];
        $new = true;

        foreach ($connexions as $connexion) {

            if ($connexion->getUserid() == Session::get("auth")) {
                $this->authRepository->update($connexion);
                $new = false;
            }

            $lastupdate = new \DateTime($connexion->getDatetime());
            $interval = $lastupdate->diff(new \DateTime());

            if ($interval->format('%y') > 0 || $interval->format('%m') > 0 || $interval->format('%d') > 0 || $interval->format('%h') > 0 || $interval->format('%i') > 5
            ) {
                $this->authRepository->remove($connexion->getId());
            } else {

                $connectedUsers[] = $this->userRepository
                                ->find($connexion->getUserid())->getName();
            }
        }

        if ($new) {
            $newConnexion = new Connexion([
                "userId" => Session::get("auth")
            ]);

            $this->authRepository->add($newConnexion);
            $connectedUsers[] = $this->userRepository
                            ->find($newConnexion->getUserid())->getName();
        }

        echo json_encode($connectedUsers);
    }

    /**
     * 
     */
    public function logout() {

        $connexion = $this->authRepository
                ->findByUserId(Session::get("auth"));

        if (is_object($connexion)):
            $this->authRepository->remove($connexion->getId());
        endif;
        Session::delete("auth");
        $this->redirect->to("default.login");
    }

}
