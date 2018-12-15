<?php declare(strict_types=1);

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Cache\DefaultCacheFactory;
use SwooleTest\Database\Manager;

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}
if (!defined('APP_PATH')) {
    define('APP_PATH', BASE_PATH . '/src');
}

require_once BASE_PATH . '/vendor/autoload.php';

$connectionParams = array(
    'dbname'    => 'swoole',
    'user'      => 'swoole',
    'password'  => 'swoole',
    'host'      => 'mysql',
    'driver'    => 'pdo_mysql',
    'driverOptions' => [
        1002 => 'SET NAMES utf8'
    ]
);

$cache = new ArrayCache;
$config = Setup::createConfiguration(true);
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);
$config->setAutoGenerateProxyClasses(true);

$paths = array(APP_PATH . '/Database/Entities');
$driver = new AnnotationDriver(new AnnotationReader(), $paths);

AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);

$em = EntityManager::create($connectionParams, $config);

$manager = Manager::getInstance();
$manager->setEm($em);
