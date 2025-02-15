<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\User; // Import de l'entité User
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Import de EntityType
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Service',
                'choices' => [
                    'Consultation' => 'consultation',
                    'Suivi médical' => 'suivi',
                    'Analyse' => 'analyse',
                    'Autre' => 'autre',
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('updated_at', null, [
                'widget' => 'single_text',
            ]);

        // Si l'utilisateur est un admin, on ajoute un champ pour sélectionner l'utilisateur
        if ($options['is_admin']) {
            $builder->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email', 
                'label' => 'Email',
                'attr' => ['class' => 'form-control']
            ]);
        } else {
            // Si l'utilisateur n'est pas un admin, on cache le champ user
            $builder->add('user', HiddenType::class, [
                'mapped' => false,
            ]);
        }
        if ($options['is_admin']) {
            $builder->add('adminComment', TextareaType::class, [
                'label' => 'Commentaire de l\'administrateur',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ]);
        }
        // Ajout d'un champ caché supplémentaire
        $builder->add('hiddenField', HiddenType::class, [
            'mapped' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
            'is_admin' => false, // Option pour savoir si l'utilisateur est admin
        ]);
    }
}