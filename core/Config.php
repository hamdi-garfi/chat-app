<?php

namespace Core;

 
class Config {

    
    private $settings = [];  // Settings 
    private static $_instance;   // 
    

    /**
     * 
     * @param array $settings
     */
    public function __construct(array $settings = []) {

        $this->settings = $settings;
    }

    /**
     * 
     * @param array $settings
     * @return \self|null
     */
    public static function getInstance(array $settings = []): ?self {

        if (is_null(self::$_instance)) {
            self::$_instance = new Config($settings);
        }
        return self::$_instance;
    }

    
   /**
    * 
    * @param string $key
    * @return array
    */
    public function get(string $key):string {

        if (!isset($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }

}
