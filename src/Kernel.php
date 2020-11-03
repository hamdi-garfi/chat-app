<?php

namespace App;

use Core\Config;
use Core\DatabaseManager;
use App\Util\Session;

/*
 * Class App (Singleton) permettant de charger les autoloaders et une instance de la base de données
 */

class Kernel {

    private static $_instance = null;
    private $db_instance = null;
    private $environment;
    private $debug;

    /**
     * Class Construct 
     *
     * @param void
     * @return void
     */
    function __construct(string $environment = "dev", int $debug = 1) {

        $this->environment = $environment; // Environnement mode 
        $this->debug = $debug;  // Debug mode
    }

    /**
     * 
     * @return Object
     */
    public static function getInstance(): ?self {

        if (is_null(self::$_instance)) {
            self::$_instance = new Kernel();
        }
        return self::$_instance;
    }

    /**
     * Load instance
     */
    public static function load(): void {
        
        Session::init();

        set_error_handler('Core\ErrorHandler::errorHandler');
        set_exception_handler('Core\ErrorHandler::exceptionHandler');
    }

    /**
     * 
     * @return DatabaseManager|null
     */
    public function getDb(): ?DatabaseManager {

        // récupération des paramètres de connexion
        $config = Config::getInstance($_ENV);

        // instanciation de la BDD si elle n'existe pas
        if (is_null($this->db_instance)) {
            $this->db_instance = new DatabaseManager(
                    $config->get('DB_NAME'),
                    $config->get('DB_USER'),
                    $config->get('DB_PASS'),
                    $config->get('DB_HOST'),
                    $config->get('DB_PORT')
            );
        }
        return $this->db_instance;
    }

}
