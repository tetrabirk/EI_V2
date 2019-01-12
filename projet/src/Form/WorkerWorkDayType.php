<?php

namespace App\Form;

use App\Entity\Worker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkerWorkDayType extends AbstractType
{
    private $workday;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->workday = $options['workday'];

        $builder

            ->add('completedTasks', CollectionType::class,array(
                'entry_type' => CompletedTaskType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => array(
                    'workday' => $this->workday,
                ),
                'mapped'=>false,
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Worker::class,
            'workday' => null,
        ]);
        $resolver->setRequired('workday');
    }
}
