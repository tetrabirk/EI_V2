<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\WorkDay;
use App\Entity\Worker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class WorkDayType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locale = 'fr_BE';
        $workday = $builder->getData() ;


        $state = key($options['places']);
        dump($state);
        $translator = new Translator($locale);
        $translator->addLoader('array',new ArrayLoader());

        $builder
            ->add('date', DateType::class,array(
                'widget' => 'choice',
                'data' => new \DateTime()

            ))

            ->add('site',EntityType::class,array(
                'class' => Site::class,
            ));

            if($state === 'instantiated'){
                $builder->add('workers', EntityType::class,array(
                    'class' => Worker::class,
                    'multiple' => true,
                ));

            }else{
                $builder->add('workers', CollectionType::class,array(
                    'entry_type' => WorkerWorkDayType::class,
                    'entry_options' => array(
                        'workday' => $workday,
                    ),
                    'allow_extra_fields' => true,
                ));
            }
        $builder

            ->add('comment', TextareaType::class,array(
                'required' => false,

            ))

            ->add('summary',SubmitType::class,array(

            ))
            ->add('next',SubmitType::class,array(

            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('places');
        $resolver->setDefaults([
            'data_class' => WorkDay::class,
            'csrf_protection' => false,
        ]);
    }
}
