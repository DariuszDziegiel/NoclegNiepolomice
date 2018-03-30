<?php

namespace ReservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFrom', TextType::class, [
                'label'  => 'Data przyjazdu',
                'attr'   => [
                    'class' => 'dateFrom',
                    'autocomplete' => 'off'
                ]
            ]);
        $builder
            ->add('dateTo', TextType::class, [
                'label' => 'Data wyjazdu',
                'attr'   => [
                    'class' => 'dateTo',
                    'autocomplete' => 'off'
                ]
            ]);

        $builder
            ->add('persons', ChoiceType::class, [
                'label' => 'Liczba osób',
                'choices' => array_combine(
                    array_merge(range(1, 2, 1), ['2 + dostawka']),
                    array_merge(range(1, 2, 1), [3])
                )
            ]);

        $builder
            ->add('name', TextType::class, [
                'label' => 'Imię'
            ]);

        $builder
            ->add('surname', TextType::class, [
                'label' => 'Nazwisko'
            ]);

        $builder
            ->add('phone', TextType::class, [
                'label' => 'Telefon'
            ]);

        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ]);

        $builder
            ->add('description', TextareaType::class, [
                'label' => 'Uwagi'
            ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ReservationBundle\Entity\ReservationForm'
        ));
    }
}
