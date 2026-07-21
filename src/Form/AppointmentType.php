<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\Specialty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('phone')
            ->add('date_start', DateType::class, [
                'widget' => 'single_text',
                'mapped' => false,
                'constraints' => [
                    new Assert\GreaterThanOrEqual('today')
                ]
            ])
            ->add('time_start', TimeType::class, [
                'widget' => 'single_text',
                'mapped' => false
            ])
            ->add('specialty', EntityType::class, [
                'class' => Specialty::class,
                'choice_label' => 'name',
            ])
            ->add('message')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
