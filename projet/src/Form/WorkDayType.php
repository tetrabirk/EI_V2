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

class WorkDayType extends AbstractType
{
    private $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locale = 'fr_BE';

        $translator = new Translator($locale);
        $translator->addLoader('array',new ArrayLoader());

        $builder
            ->add('date')

            ->add('workers', EntityType::class,array(
                'class' => Worker::class,

            ))

            ->add('completedTasks', CollectionType::class,array(
                'entry_type' => CompletedTaskType::class,
                'entry_options' => array(
                    'current_site' => $this->site,
                )


            ))
            ->add('comment')
            ->add('site')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WorkDay::class,
        ]);
    }
}
