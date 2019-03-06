<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shortName')
            ->add('name')
            ->add('address')
            ->add('postCode')
            ->add('locality')
            ->add('country')
            ->add('latitude')
            ->add('longitude')
            ->add('active')
            ->add('firstWorkDay')
            ->add('lastWorkDay')
            ->add('finished')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}
