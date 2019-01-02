<?php

namespace App\Form;

use App\Entity\Participation;
use App\Entity\Person;
use App\Entity\Site;
use App\Repository\ParticipantionRepository;
use App\Repository\PersonRepository;
use App\Repository\SiteRepository;
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

class PersonSearchType extends AbstractType
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

            ->add('role',EntityType::class,array(
                'class' => Participation::class,
                'required' => false,

                'placeholder' => $translator->trans('--All--'),
                'empty_data' => null,
                'multiple' =>true,
                'query_builder' => function (ParticipantionRepository $par){
                    return $par->getRolesSimple();
                },

            ))
            ->add('company',EntityType::class,array(
                'class' => Person::class,
                'required' => false,

                'placeholder' => $translator->trans('--All--'),
                'empty_data' => null,
                'multiple' =>true,
                'query_builder' => function (PersonRepository $par){
                    return $par->getCompaniesSimple();
                },

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
