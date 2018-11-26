<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SearchType extends AbstractType
{

    private $router;
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
        ->setMethod('GET')
            ->setAction($this->router->generate('search',array(),UrlGeneratorInterface::ABSOLUTE_URL))
        ->add('string',TextType::class,array(
          'required' =>false,
          'empty_data' => null,
        ))
            ->add('search',SubmitType::class,array(
                'attr'=>array('class'=>'search'),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}
