<?php

namespace App\Form;

use App\Entity\Site;
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

class SiteSearchType extends AbstractType
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
            ->add('string',SearchType::class, array(
                'required' => false,
                'empty_data' => null,

            ))
            ->add('firstDayMin',DateType::class, array(
                'required' => false,
                'empty_data' => null,
            ))
            ->add('firstDayMax',DateType::class, array(
                'required' => false,
                'empty_data' => null,
            ))
            ->add('lastDayMin',DateType::class, array(
                'required' => false,
                'empty_data' => null,
            ))
            ->add('lastDayMax',DateType::class, array(
                'required' => false,
                'empty_data' => null,
            ))
            ->add('distance', ChoiceType::class,array(
                'expanded' => false,
                'multiple' => false,
                'empty_data' => null,
                'required' => false,

                'choices'  => array(
                    '5km' => 5,
                    '10km' => 10,
                    '25km' => 25,
                    '50km' => 50,
                    '100km'=> 100,
                ),
            ))
            ->add('finished',ChoiceType::class,array(
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'empty_data' => null,

                'choices'  => array(
                    $translator->trans('finished') => 1,
                    $translator->trans('ongoing') =>0,

                ),

            ))
            ->add('active',ChoiceType::class,array(
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'empty_data' => null,

                'choices'  => array(
                    $translator->trans('inactive') => 0,
                    $translator->trans('active') => 1

                ),
            ))

            ->add('flagged',ChoiceType::class,array(
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'empty_data' => null,

                'choices'  => array(
                    $translator->trans('flagged') => 1,
                    $translator->trans('not flagged') => 0,

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
