<?php

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use SwooleTest\Database\Manager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$paths = array(realpath(__DIR__ . '/src/Database/Entities'));

$isDevMode = true;

$connectionParams = array(
    'url' => 'sqlite:///' . './data/blog.db'
);

$config = Setup::createConfiguration($isDevMode);
$driver = new AnnotationDriver(new AnnotationReader(), $paths);

AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);

$em = EntityManager::create($connectionParams, $config);

$manager = Manager::getInstance();
$manager->setEm($em);

$platform = $em->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping(' ', 'string');
$platform->registerDoctrineTypeMapping('', 'string');

return ConsoleRunner::createHelperSet($em);
