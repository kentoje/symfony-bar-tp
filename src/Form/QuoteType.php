<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteType extends AbstractType
{
    public const PRIORITY_NONE = 'none';
    public const PRIORITY_IMPORTANT = 'important';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['required' => true])
            ->add('content', TextareaType::class)
            ->add('position', ChoiceType::class, [
                'choices' => [
                    'Important' => self::PRIORITY_IMPORTANT,
                    'No position' => self::PRIORITY_NONE,
                ],
            ])
            ->add(
                'save',
                SubmitType::class, ['label' => 'Create Quote'],
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}
