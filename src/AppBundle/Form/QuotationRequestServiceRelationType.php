<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 16/02/15
 * Time: 21:10
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\BusinessServiceRepository;


class QuotationRequestServiceRelationType extends AbstractType
{
    /**
     * @var  BusinessServiceRepository
     */
    private $bsr;

    public function __construct(BusinessServiceRepository $bsr)
    {
        $this->bsr = $bsr;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('businessServiceRef', 'choice',
                [
                    'choices' => $this->bsr->getChoices(false),
                    'label' => 'Référence du service',
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\QuotationRequestServiceRelation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_quotationrequestservicerelation';
    }
}
