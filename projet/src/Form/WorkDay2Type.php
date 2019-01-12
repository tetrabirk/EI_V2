<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\WorkDay;
use App\Entity\Worker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class WorkDay2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locale = 'fr_BE';
        /**
         * var WorkDay $workday
         */
        $workday = $builder->getData();
        $translator = new Translator($locale);
        $translator->addLoader('array',new ArrayLoader());

        $builder
            ->add('workers', CollectionType::class,array(
                'entry_type' => WorkerWorkDayType::class,
                'entry_options' => array(
                    'workday' => $workday,
                )
            ))
           ->add('comment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WorkDay::class,
        ]);
    }
}