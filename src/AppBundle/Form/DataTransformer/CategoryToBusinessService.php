<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 24/02/15
 * Time: 22:48
 */

namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\QuotationRequestServiceRelation;

class CategoryToBusinessService implements DataTransformerInterface
{

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * No need to transform, returns empty array
     *
     * @param  $choices |null
     * @return array
     */
    public function transform($choices)
    {
        return array();
    }

    /**
     * Transforms a business service reference to an array of QuotationRequestServiceRelation
     *
     * @param  array $references
     * @return array|null
     */
    public function reverseTransform($references)
    {

        if (!$references) {
            return null;
        } else {
            if (!is_array($references)) {
                throw new TransformationFailedException(
                    "Parameter 'references' must be an array");
            } else {

                $qrsr = [];
                foreach ($references as $ref) {

                    $tmpQrsr = new QuotationRequestServiceRelation();
                    $tmpQrsr->setBusinessServiceRef($ref);
                    $qrsr[] = $tmpQrsr;
                }

                return $qrsr;

            }
        }

    }


}




