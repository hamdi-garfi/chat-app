<?php

namespace Core;

use \PDO;

class DatabaseManager {

    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $db_port;
    private $pdo;

    /**
     * 
     * @param string $db_name
     * @param string $db_user
     * @param string $db_pass
     * @param string $db_host
     */
    public function __construct(string $db_name, string $db_user
            , string $db_pass, string $db_host, int $db_port = 5432) {

        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
        $this->db_port = $db_port;
        // Connect To database ;
        $this->connect();
    }

    /**
     * Connect to the database and return an instance of \PDO object
     * @return \PDO
     * @throws \Exception
     */
    public function connect(): void {

        if ($this->pdo === null) {
            // connect to the postgresql database
            $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
                    $this->db_host,
                    $this->db_port,
                    $this->db_name,
                    $this->db_user,
                    $this->db_pass
            );

            $pdo = new PDO($conStr);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
    }

    /**
     * 
     * @param string $statement
     * @param bool $singleResult
     * @return array
     */
    public function query($statement, $singleResult = false) {

        $req = $this->pdo->query($statement);
        if (
                strpos($statement, 'UPDATE') === 0 ||
                strpos($statement, 'INSERT') === 0 ||
                strpos($statement, 'DELETE') === 0
        ) {
            return $req;
        }

        $req->setFetchMode(PDO::FETCH_ASSOC);

        return (true === $singleResult) ? $req->fetch() : $req->fetchAll();
    }

    /**
     * 
     * @param string $statement
     * @param string $attributes
     * @param bool $singleResult
     * @return array
     */
    public function prepare($statement, $attributes, $singleResult = false) {
        $req = $this->pdo->prepare($statement);
        $res = $req->execute($attributes);
        if (
                strpos($statement, 'UPDATE') === 0 ||
                strpos($statement, 'INSERT') === 0 ||
                strpos($statement, 'DELETE') === 0
        ) {
            return $res;
        }
        $req->setFetchMode(PDO::FETCH_ASSOC);

        return (true === $singleResult) ? $req->fetch() : $req->fetchAll();
    }

    /**
     * 
     * @return int
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

}
