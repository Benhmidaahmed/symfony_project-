<?php

namespace App\Form;

use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Dans AppointmentType
            $builder->add('user', EntityType::class, [
                'class' => User::class,
                
            ]);

        $builder
            ->add('client')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('status')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('updated_at', null, [
                'widget' => 'single_text',
            ])
            ->add('user', HiddenType::class, [
                'mapped' => false, // Si ce champ n'est pas utilisé dans l'objet.
            ])
            ->add('hiddenField', HiddenType::class, [
                'mapped' => false, // si ce champ n'est pas lié à une entité
            ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
