<?php

namespace Core;

use Twig\{
    Loader\FilesystemLoader,
    Environment
};
use App\Repository\{
    MessageRepository,
    UserRepository,
    AuthRepository
};
use App\Kernel;
use App\Util\{
    Redirect
} ;

class BaseController {

    protected $template = 'default';
    protected $viewPath;
    protected $messageRepository;
    protected $userRepository;
    protected $authRepository;
    protected $redirect;
    protected $session;
    protected $twig;

    /**
     * Class constructor
     *
     * @param Parameters from the route
     *
     * @return void
     */
    function __construct() {

        $currentInstance = Kernel::getInstance();
        $this->messageRepository = new MessageRepository($currentInstance->getDb());
        $this->userRepository = new UserRepository($currentInstance->getDb());
        $this->authRepository = new AuthRepository($currentInstance->getDb());
        $this->redirect = new Redirect();
        // Tiwg templating
        $this->twig = new Environment(
                new FilesystemLoader(dirname(__DIR__)
                        . '/src/templates')
        );
    }

    /**
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call(string $name, array $args = []) {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }
    
    /**
     * 
     * @param mixed $data
     * @return void
     */
    protected function render(?string $path, ?array $parameters = []): void {
        echo $this->twig->render($path,$parameters) ; 
    }
    
    /**
     * 
     * @param string|null $data
     * @return void
     */
    protected function response(mixed $data): void {
        echo json_encode($data);
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before() {
        
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after() {
        
    }

}
