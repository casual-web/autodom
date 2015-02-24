<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 23/02/15
 * Time: 21:09
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FrontQuotationRequestType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('baseqr', new BaseQuotationRequestType(), array(
                'data_class' => 'AppBundle\Entity\QuotationRequest'))
            ->add(
                'business_services',
                'choice', [
                    'label' => 'Type d \'intervention',
                    'choices' => $options['enabled_business_services'],
                    'expanded' => true,
                    'multiple' => true,
                    "mapped" => false,
                ]
            );

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\QuotationRequest',
            'enabled_business_services' => array()
        ));
    }


    public function getName()
    {
        return 'appbundle_frontquotationrequest';
    }


}