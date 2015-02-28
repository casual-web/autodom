<?php
/**
 * Created by PhpStorm.
 * User: olivier
 * Date: 27/02/15
 * Time: 14:35
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageSiteType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['em'];
        $bsRepo = $entityManager->getRepository('AppBundle:BusinessService');

        $builder
            ->add('file', 'file', ['label' => 'Fichier'])
            ->add('location', null, ['label' => 'Lieu de l\'intervention'])
            ->add('vehicleModel', null, ['label' => 'Modèle du véhicule'])
            ->add('damageType', null, ['label' => 'Type de dommage'])
            ->add('carouselOrder', null, ['label' => 'Ordre dans le caroussel par catégorie'])
            ->add('businessServiceRef', 'choice', [
                'label' => 'Catégorie du service',
                'choices' => $bsRepo->getChoices()
            ]);

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ImageSite'
        ));


        $resolver->setRequired(array(
            'em'
        ));

        $resolver->setAllowedTypes(array(
            'em' => 'Doctrine\Common\Persistence\ObjectManager'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_imagesite';
    }
}