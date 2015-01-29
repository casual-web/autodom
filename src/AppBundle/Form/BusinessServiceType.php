<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BusinessServiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ref', 'text' , array(
                'label'     => 'Référence',
            ))
            ->add('name', 'text' , array(
                'label'     => 'Nom',
            ))
            ->add('description')
            ->add('enabled', 'checkbox', array(
                'label'     => 'Actif',
                'required'  => false))
        ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BusinessService'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_businessservice';
    }
}
