<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\WorkDay;
use App\Entity\Worker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class WorkDay1Type extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locale = 'fr_BE';

        $translator = new Translator($locale);
        $translator->addLoader('array',new ArrayLoader());

        $builder
            ->add('date', DateType::class,array(
                'widget' => 'choice',
                'data' => new \DateTime()

            ))

            ->add('site',EntityType::class,array(
                'class' => Site::class,
            ))

            ->add('workers', EntityType::class,array(
                'class' => Worker::class,
                'multiple' => true,
            ))
            ->add('next',SubmitType::class,array(

            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WorkDay::class,
        ]);
    }
}
