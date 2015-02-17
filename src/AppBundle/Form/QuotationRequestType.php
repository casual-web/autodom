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

            ->add('vehicleModel', 'text', ['label' => 'Marque et modèle du véhicule'])
            ->add('problemDescription', 'textarea', ['label' => 'Description du problème'])
            ->add('hasShelter', 'checkbox', ['required' => false, 'label' => 'Je dispose d\'un abri (garage, tonelle, ...) et d\'une alimentation électrique'])
            ->add('first_name', 'text', ['label' => 'Nom'])
            ->add('last_name', 'text', ['label' => 'Prénom'])
            ->add('email')
            ->add('phone', 'text', ['label' => 'Téléphone'])
            ->add('address', 'text', ['label' => 'Adresse postale'])
            ->add('contactOrigin', null, ['label' => 'Dites-nous comment vous nous avez trouvé :'])
            ->add('status', null, ['label' => 'Etat de la demande'])
            ->add(
                'quotationRequestServiceRelations',
                'collection', [
                    'type' => new QuotationRequestServiceRelationType(),
                    'allow_add' => true,
                    'by_reference' => false,
                ]
            );
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
