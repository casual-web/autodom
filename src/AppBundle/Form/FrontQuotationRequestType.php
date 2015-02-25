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
use AppBundle\Form\DataTransformer\CategoryToBusinessService;

class FrontQuotationRequestType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $entityManager = $options['em'];
        $transformer = new CategoryToBusinessService($entityManager);
        $bsRepo = $entityManager->getRepository('AppBundle:BusinessService');

        $builder
            ->add('baseqr', new BaseQuotationRequestType(), array(
                'data_class' => 'AppBundle\Entity\QuotationRequest',
                'label' => false))
            ->add(
                $builder->create('quotationRequestServiceRelations',
                    'choice', [
                        'label' => 'Type d \'intervention',
                        'choices' => $bsRepo->getChoices(),
                        'expanded' => true,
                        'multiple' => true,
                        'mapped' => false,
                    ])->addModelTransformer($transformer));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\QuotationRequest'
        ));

        $resolver->setRequired(array(
            'em'
        ));

        $resolver->setAllowedTypes(array(
            'em' => 'Doctrine\Common\Persistence\ObjectManager'
        ));

    }


    public function getName()
    {
        return 'appbundle_frontquotationrequest';
    }


}