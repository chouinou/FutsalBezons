<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

// Formulaire d'enregistrement
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $fields = [
            'firstName' => [TextType::class, 'Prénom', 50],
            'lastName' => [TextType::class, 'Nom', 50],
            'email' => [EmailType::class, 'Email', 180],
            'phone' => [TelType::class, 'Téléphone', 20],
        ];

        foreach ($fields as $name => [$type, $label, $max]) {
            $constraints = [new NotBlank(), new Length(max: $max)];
            if ('email' === $name) {
                $constraints[] = new Email();
            }

            $builder->add($name, $type, [
                'label' => $label,
                'empty_data' => '',
                'constraints' => $constraints,
            ]);
        }

        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => ['label' => 'Mot de passe (12 caractères minimum)'],
                'second_options' => ['label' => 'Confirmation'],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'constraints' => [new NotBlank(), new Length(min: 12, max: 4096)],
            ])
            ->add('isAdult', CheckboxType::class, [
                'label' => 'J’ai 18 ans ou plus',
                'mapped' => false,
                'constraints' => [new IsTrue(message: 'L’inscription en ligne est réservée aux majeurs.')],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Users::class]);
    }
}