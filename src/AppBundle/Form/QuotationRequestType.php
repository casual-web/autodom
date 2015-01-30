<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuotationRequestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vehicleModel')
            ->add('problemDescription')
            ->add('hasShelter')
            ->add('first_name')
            ->add('last_name')
            ->add('email')
            ->add('phone')
            ->add('address')
            ->add('contactOrigin')
            ->add('created')
            ->add('status')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\QuotationRequest'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_quotationrequest';
    }
}
