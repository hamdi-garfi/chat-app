<?php

namespace App\Entity;

use Core\EntityManager as Entity;

class Message extends Entity {

    private $_id;
    private $_userId;
    private $_createdAt;
    private $_content;

    /**
     * 
     * @return serial number (int)
     */
    public function getId():int {
        return $this->_id;
    }

    /**
     * 
     * @param int $id
     * @return $this
     */
    public function setId(int $id):self {
        $this->_id = $id;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getUserid() {
        return $this->_userId;
    }

    /**
     * 
     * @param object $userId
     * @return $this
     */
    public function setUserid($userId) {
        $this->_userId = $userId;

        return $this;
    }

    /**
     * 
     * @return type
     */
    function getCreatedAt() {
        return $this->_createdAt;
    }

    function setCreatedAt($_createdAt): void {
        $this->_createdAt = $_createdAt;
    }

    public function getContent() {
        return $this->_content;
    }

    public function setContent($content) {
        $this->_content = $content;

        return $this;
    }

}
