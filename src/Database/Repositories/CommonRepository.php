<?php declare(strict_types=1);

namespace SwooleTest\Database\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CommonRepository
 * @package SwooleTest\Database\Repositories
 */
class CommonRepository extends EntityRepository
{
    /**
     * @param string $field
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCount($field = 'id'): int
    {
        $alias = 'alias_' . uniqid();

        /* @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder()->select('count(' . $alias . '.' . $field . ') AS count')
            ->from($this->_entityName, $alias);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

}
