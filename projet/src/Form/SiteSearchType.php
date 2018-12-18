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
            ->add('creationDateMin',DateType::class, array(
                'required' => false,
                'empty_data' => null,
            ))
            ->add('creationDateMax',DateType::class, array(
                'required' => false,
                'empty_data' => null,
            ))
            ->add('lastModificationMin',DateType::class, array(
                'required' => false,
                'empty_data' => null,
            ))
            ->add('lastModificationMax',DateType::class, array(
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
                'placeholder' => $translator->trans('ongoing'),
                'empty_data' => 0,

                'choices'  => array(
                    $translator->trans('finished') => 1,
                ),

            ))
            ->add('validated',ChoiceType::class,array(
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => 'pending',
                'empty_data' => 0,

                'choices'  => array(
                    'validated' => 1,
                ),
            ))

            ->add('flagged',ChoiceType::class,array(
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'placeholder' => false,

                'choices'  => array(

                    'flagged' => 1,
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
