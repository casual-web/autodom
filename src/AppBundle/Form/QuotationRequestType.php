<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\QuotationRequest;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;



class QuotationRequestType extends AbstractType
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
            ->add('status', null, ['label' => 'Etat de la demande'])
            ->add(
                'quotationRequestServiceRelations',
                'collection', [
                    'label' => 'Référence du service',
                    'type' => new QuotationRequestServiceRelationType($options['enabled_business_services']),
                    'allow_add' => true,
                    'by_reference' => false,
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

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_quotationrequest';
    }
}
