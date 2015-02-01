<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 01/02/15
 * Time: 00:58
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BusinessServiceRepository
 */
class BusinessServiceRepository extends EntityRepository
{
    public function findByRefList(array $refList)
    {

        $qb = $this->createQueryBuilder('s');
        $qb->where($qb->expr()->in('s.ref', $refList));
        return $qb->getQuery()->execute();

    }

}