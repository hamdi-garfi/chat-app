<?php

namespace App\Repository;

use Core\DatabaseManager;
use App\Entity\User;

class UserRepository {

    private $db;

    public function __construct(DatabaseManager $db) {
        $this->db = $db;
    }

    /**
     * 
     * @param User $user
     * @return void
     */
    public function add(User $user): void {

        $statement = 'INSERT INTO "user" (name, password,created_at, username) VALUES(?, ?, ? ,?)';
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $this->db->prepare($statement, 
                [$user->getName(),$user->getPassword(),$now,$user->getUsername()], true);
        $user->setId($this->db->lastInsertId());
    }

    public function delete($id) {
        $statement = 'DELETE FROM "user" WHERE id = ?';
        $this->db->prepare($statement, [(int) $id], true);
    }

    public function update(User $user) {
        $statement = 'UPDATE "user" SET name = ?, password = ? WHERE id = ?';
        $this->db->prepare($statement, [$user->getName(), $user->getPassword(), $user->getId()], true);
    }

    public function find($id) {

        $statement = 'SELECT * FROM "user" WHERE id = ?';
        $data = $this->db->prepare($statement, [$id], true);

        return (is_array($data)) ? new User($data) : false;
    }

    public function findByUsername(string $username) {

        $statement = "SELECT * FROM user WHERE 'username' = ?";
        $data = $this->db->prepare($statement, [$username], true);

        if ($data) {
            return new User($data);
        } else {
            return false;
        }
    }

    public function findByName($name) {
        $statement = 'SELECT * FROM user WHERE name = ?';
        $data = $this->db->prepare($statement, [$name], true);

        if ($data) {
            return new User($data);
        } else {
            return false;
        }
    }

    public function findAll() {
        $users = [];

        $statement = 'SELECT * FROM \'user\'';
        $list = $this->db->prepare($statement, [], false);

        foreach ($list as $data) {
            $users[] = new User($data);
        }

        return $users;
    }

}
