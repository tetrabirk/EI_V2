<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Worker;
use App\Repository\SiteRepository;
use App\Repository\WorkerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class WorkDaySearchType extends AbstractType
{

    public function __construct()
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $locale = 'fr_BE';

        $translator = new Translator($locale);
        $translator->addLoader('array',new ArrayLoader());

        $builder
            ->add('dateMin',DateType::class, array(
                'required' => false,
                'empty_data' => null,
            ))
            ->add('dateMax',DateType::class, array(
                'required' => false,
                'empty_data' => null,
            ))
            ->add('site',EntityType::class,array(
                'class' => Site::class,
                'required' => false,

                'placeholder' => $translator->trans('--All--'),
                'empty_data' => null,
                'multiple' =>true,
                'query_builder' => function (SiteRepository $sr){
                    return $sr->getSitesSimple();
                },

            ))
            ->add('author',EntityType::class,array(
                'class' => Worker::class,
                'required' => false,

                'placeholder' => $translator->trans('--All--'),
                'empty_data' => null,
                'multiple' =>true,
                'query_builder' => function (WorkerRepository $wr){
                    return $wr->getAuthorsSimple();
                },

            ))
            ->add('worker',EntityType::class,array(
                'class' => Worker::class,
                'required' => false,

                'placeholder' => $translator->trans('--All--'),
                'empty_data' => null,
                'multiple' =>true,
                'query_builder' => function (WorkerRepository $wr){
                    return $wr->getWorkersSimple();
                },

            ))


            ->add('validated',ChoiceType::class,array(
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'empty_data' => null,

                'choices'  => array(
                    $translator->trans('validated') => 1,
                    $translator->trans('not validated') => 0,
                ),

            ))

            ->add('flagged',ChoiceType::class,array(
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'placeholder' => false,

                'choices'  => array(
                    $translator->trans('flagged') => 1,
                ),
            ))

            ->add('search', SubmitType::class, array(
                'attr' => array('class' => 'search'),
            ));

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
