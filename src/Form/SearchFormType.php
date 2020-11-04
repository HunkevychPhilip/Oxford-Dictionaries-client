<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word', TextType::class, [
                'attr' => [
                    'placeholder' => 'for example, "run"',
                    'maxlength' => 30,
                    'pattern' => "^[A-Za-z]+$",
                ],
            ]);
    }
}


//->add('fields', ChoiceType::class, [
//    'choices' => [
//        'Definitions' => 'definitions',
//        'Pronunciations' => 'pronunciations',
//        'Examples' => 'examples',
//    ],
//    'expanded' => true,
//    'multiple' => true,
//])


//->add('language', ChoiceType::class, [
//    'choices' => [
//        'British English' => 'en-gb',
//        'American English' => 'en-us',
//    ]
//]);