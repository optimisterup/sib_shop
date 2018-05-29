<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\ArrayToObjectTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use AppBundle\Entity\Media;
use Symfony\Component\Form\CallbackTransformer;

class UserMediaType extends AbstractType
{
//    private $transformer;
//
//    public function __construct(EntityManager $manager)
//    {
//        $this->transformer = new ArrayToObjectTransformer($manager);
//    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('imageFile', VichImageType::class, array(
                'required' => true,
//                'mapped'       => 'product',
                'allow_delete' => true,
                'by_reference' => false,
//                'invalid_message' => 'That is not a valid issue number',
            ));
        /*$builder->get('imageFile')
            ->addModelTransformer($this->transformer);*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\AppBundle\Entity\UserMedia',
            'virtual' => true,
        ));
    }
}