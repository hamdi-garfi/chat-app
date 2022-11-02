<?php

require_once "vendor/autoload.php";

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$paths = array("/path/to/entity-files");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_pgsql',
    'user'     => getenv("DB_USER"),
    'password' => getenv("DB_PASS"),
    'dbname'   => getenv("DB_NAME"),
);

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);