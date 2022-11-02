<?php

namespace App\Controller;

use Core\BaseController;
use App\Entity\{Auth as Connexion,Message};
use App\Util\{Session, Request};

class ChatController extends BaseController {

    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        if (!Session::exists("auth")) {
            $this->redirect->to("default.login");
        }
    }

    /**
     * 
     * @return mixed
     */
    public function index(): mixed {

        if (Request::exists("post")) {
            $message = new Message([
                "content" => Request::post("content"),
                "userId" => Session::get("auth")
            ]);
            $this->messageRepository->add($message);
        }
        // Render page index
        return $this->render('home/index.html.twig');
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

        return $this->response($response);
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

        return $this->response($connectedUsers);
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
