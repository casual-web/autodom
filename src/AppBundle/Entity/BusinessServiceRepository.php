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

    /**
     * get services enabled only by default or with a suffix if $filterEnabled=false
     * @param bool $filterEnabled
     * @return array
     */
    public function getChoices($filterEnabled = true)
    {

        if ($filterEnabled) {
        }
        $qb = $this->createQueryBuilder('s');
        $qb->select('s.ref, s.name, s.enabled');

        $results = $qb->getQuery()->execute();
        $choices = [];
        foreach ($results as $item) {
            if ($item['enabled'] === true) {
                $choices[$item['ref']] = $item['name'];
            } else {
                if ($filterEnabled === false) {
                    $choices[$item['ref']] = sprintf('%s (désactivé)', $item['name']);
                } else {
                    unset($choices[$item['ref']]);
                }
            }
        }
        return $choices;

    }

}