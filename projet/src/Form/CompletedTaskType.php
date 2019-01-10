<?php

namespace App\Form;

use App\Entity\CompletedTask;
use App\Entity\Site;
use App\Repository\TaskRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompletedTaskType extends AbstractType
{
    private $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('duration', DateIntervalType::class, array(
                'widget'      => 'choice',
                'with_years'  => false,
                'with_months' => false,
                'with_days'   => false,
                'with_hours'  => true,
                'with_minutes' => true,
                'hours' => range(0, 8),
                'minutes' => range(0, 60,15)
            ))
            ->add('task', EntityType::class, array(
                'query_builder' => function (TaskRepository $tr) {
                    return $tr->createQueryBuilder('t')
                        ->where('t.site LIKE :site')
                        ->setParameter('site', $this->site);
                },
            ))
           // ->add('worker')
           // ->add('workday')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompletedTask::class,
        ]);
    }
}
