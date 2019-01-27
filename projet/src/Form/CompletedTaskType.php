<?php

namespace App\Form;

use App\Entity\CompletedTask;
use App\Entity\WorkDay;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompletedTaskType extends AbstractType
{
    /**
     * @var WorkDay $workday
     */
    private $workday;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->workday = $options['workday'];

            dump('hoho');
        $builder
            ->add('duration', DateIntervalType::class, array(
                'widget'      => 'choice',
                'with_years'  => false,
                'with_months' => false,
                'with_days'   => false,
                'with_hours'  => true,
                'with_minutes' => true,
                'hours' => range(0, 8),
                //TODO custom prototype in WorkerWorkdayType where values = 'showed text'
                'minutes' => range(0, 45,15)
            ))
            ->add('task', EntityType::class, array(
                'class' => Task::class,

                'query_builder' => function (TaskRepository $tr) {
                    return $tr->createQueryBuilder('t')
                        ->where('t.site = :site')
                        ->setParameter('site', $this->workday->getSite());
                },
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompletedTask::class,
            'workday' => null,
        ]);
        $resolver->setRequired('workday');

    }
}
