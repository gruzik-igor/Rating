<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control border-input',
                    'placeholder' => 'Enter your E-mail',
                    'title' => 'Your E-mail'
                ],
                'label' => 'E-mail: ',
                'required' => true
            ])
            ->add('password', RepeatedType::class, [
                'property_path'     => 'plainPassword',
                'type'              => PasswordType::class,
                'invalid_message'   => 'The password fields must match.',
                'options'           => ['attr' => [
                    'class'         => 'password-field',
                    'placeholder'   => 'Enter your password',
                    'title'         => 'Minimum 5 symbols',
                    'maxlength'     => '50'
                ]],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'allow_extra_fields' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_sign_up';
    }
}
