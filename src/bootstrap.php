<?php declare(strict_types=1);

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use SwooleTest\Database\Manager;

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}
if (!defined('APP_PATH')) {
    define('APP_PATH', BASE_PATH . '/src');
}

require_once BASE_PATH . '/vendor/autoload.php';

$connectionParams = array(
    'url' => 'sqlite:///' . BASE_PATH  . '/data/blog.db'
);

$paths = array(APP_PATH . '/Database/Entities');

$config = Setup::createConfiguration(true);
$driver = new AnnotationDriver(new AnnotationReader(), $paths);

AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);

$em = EntityManager::create($connectionParams, $config);

$manager = Manager::getInstance();
$manager->setEm($em);
