<?php

namespace App\Entity;

use Core\EntityManager as Entity;

class User extends Entity {

    private $_id;
    private $_name;
    private $_username;
    private $_password;

    /**
     * 
     * @return int|null
     */
    public function getId(): ?int {
        return $this->_id;
    }

    /**
     * 
     * @param int $id
     * @return \self
     */
    public function setId(int $id): self {
        $this->_id = $id;

        return $this;
    }

    /**
     * 
     * @return string|null
     */
    function getUsername(): ?string {
        return $this->_username;
    }

    /**
     * 
     * @param string $_username
     * @return void
     */
    function setUsername(string $_username): void {
        $this->_username = $_username;
    }

    /**
     * 
     * @return string|null
     */
    public function getName(): ?string {
        return $this->_name;
    }

    /**
     * 
     * @param string $name
     * @return \self
     */
    public function setName(string $name): self {
        $this->_name = $name;

        return $this;
    }

    /**
     * 
     * @return string|null
     */
    public function getPassword(): ?string {
        return $this->_password;
    }

    /**
     * 
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self {
        $this->_password = $password;

        return $this;
    }

}
