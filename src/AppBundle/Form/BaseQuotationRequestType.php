<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 23/02/15
 * Time: 21:13
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class BaseQuotationRequestType extends AbstractType
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
            ->add('firstName', 'text', ['label' => 'Nom'])
            ->add('lastName', 'text', ['label' => 'Prénom'])
            ->add('email')
            ->add('phone', 'text', ['label' => 'Téléphone'])
            ->add('address', 'text', ['label' => 'Adresse postale'])
            ->add('contactOrigin', null, ['label' => 'Dites-nous comment vous nous avez trouvé :']);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
        ));
    }

    public function getName()
    {
        return 'appbundle_basequotationrequest';
    }
}