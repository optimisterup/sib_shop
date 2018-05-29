<?php
namespace AppBundle\Form;

use AppBundle\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use AppBundle\Entity\UserMedia;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('media', MediaType::class, array(
                'required'      => true,
                //'mapped'       => 'product',
                'allow_delete'  => true,
                'by_reference'  => false
            ));
//        dump('asd');die;
//        $builder->remove('media');
    }

//    public function getParent()
//    {
//        return 'FOS\UserBundle\Form\Type\ProfileFormType';
//    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\AppBundle\Entity\ProductMedia',
        ));
    }

    public function getBlockPrefix()
    {
        return 'fos_user_profile';
    }

}