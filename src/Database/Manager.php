<?php

namespace SwooleTest\Database;

use Doctrine\ORM\EntityManager;

/**
 * Class Manager
 * @package SwooleTest\Database
 */
class Manager
{
    /**
     * @var Manager $instance
     */
    private static $instance;

    /**
     * @var EntityManager $em
     */
    private $em;

    /**
     * @return Manager
     */
    public static function getInstance(): Manager
    {
        if(!self::$instance instanceof Manager) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param EntityManager $em
     */
    public function setEm(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }
}