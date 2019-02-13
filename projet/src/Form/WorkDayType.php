<?php

//https://stackoverflow.com/questions/25291607/symfony2-how-to-stop-form-handlerequest-from-nulling-fields-that-dont-exist

namespace App\Form;

use App\Entity\Site;
use App\Entity\WorkDay;
use App\Entity\Worker;
use App\Form\DataTransformer\IdToSiteTransformer;
use App\Form\EventListener\NewWorkDaySubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class WorkDayType extends AbstractType
{

    private $workday;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locale = 'fr_BE';

        $this->workday = $builder->getData() ;

        $translator = new Translator($locale);
        $translator->addLoader('array',new ArrayLoader());

        $builder

            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){
                $form = $event->getForm();
                $workday = $form->getConfig()->getData();
                $state = $workday->getState();

                if($state === null || $state === 'instantiated')
                {
                    $form
                        ->add('date', DateType::class,array(
                            'widget' => 'choice',
                            'data' => new \DateTime()
                        ))
                        ->add('site',EntityType::class,array(
                            'class' => Site::class,
                        ))

                        ->add('workers', EntityType::class, array(
                            'class' => Worker::class,
                            'multiple' => true,
                        ))
                        ->add('next',SubmitType::class,array(

                        ));

                }elseif($state === 'to_complete' ){
                    $form

                        ->add('workers', CollectionType::class,array(
                            'entry_type' => WorkerWorkDayType::class,
                            'entry_options' => array(
                                'workday' => $workday,
                            ),
                            'allow_extra_fields' => true,
                        ))
                        ->add('comment', TextareaType::class,array(
                            'required' => false,
                        ))
                        ->add('next',SubmitType::class,array(

                        ));

                }elseif($state === 'edition' ){
                    $form
                        ->add('date', DateType::class,array(
                            'widget' => 'choice',
                            'data' => new \DateTime()
                        ))

                        ->add('workers', EntityType::class, array(
                            'class' => Worker::class,
                            'multiple' => true,
                        ))
                        ->add('next',SubmitType::class,array(

                        ));
                }
            });

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WorkDay::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,

        ]);
    }
}
