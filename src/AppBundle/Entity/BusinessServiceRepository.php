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

    public function findEnabled()
    {
        return $this->findBy(array('enabled' => '1'));
    }

    public function getChoices()
    {

        $qb = $this->createQueryBuilder('s');
        $qb->select('s.ref, s.name')
            ->where('s.enabled = 1');
        $results = $qb->getQuery()->execute();
        $choices = [];
        foreach ($results as $item) {
            $choices[$item['ref']] = $item['name'];
        }
        return $choices;

    }

}