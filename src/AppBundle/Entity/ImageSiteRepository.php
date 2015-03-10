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
 * ImageSiteRepository
 */
class ImageSiteRepository extends EntityRepository
{

    /**
     * @param array $businessServiceRef business service reference
     * @return array
     */
    public function findVisibleByService($businessServiceRef)
    {
        $is = $this->createQueryBuilder('i');
        $is->where("i.businessServiceRef = '$businessServiceRef'")
            ->andWhere('i.visible = 1')
            ->orderBy('i.carouselOrder', 'ASC');

        return $is->getQuery()->execute();
    }

    /**
     * redefine findAll to have images properly ordered
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(
            array(),
            array('businessServiceRef' => 'ASC', 'carouselOrder' => 'ASC'));
    }


}