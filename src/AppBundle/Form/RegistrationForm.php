<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationForm extends AbstractType
{
    public  function  buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['attr' => ['placeholder' => 'Enter your name', 'class' => 'form-control border-input'], 'required' => true,'label' => 'Username: '])
            ->add('fullName', TextType::class, ['attr' => ['placeholder' => 'Enter your fullName', 'class' => 'form-control border-input'], 'label' => 'fullName: '])
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'Please enter your email', 'class' => 'form-control border-input'], 'required' => true,'label' => 'E-mail: '])
            ->add('role', HiddenType::class, ['attr' => ['value' => 'ROLE_USER']])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message'   => 'The password fields must match!',
                'options'           => ['attr' => [
                    'class'         => 'form-control border-input',
                    'placeholder'   => 'Enter your password',
                    'title'         => 'Minimum 5 symbols',
                    'maxlength'     => '50'
                ]],
                'required' => true,
                'first_options'  => array('attr' => ['placeholder' => 'Please enter your password', 'class' => 'form-control border-input'],'label' => 'Password'),
                'second_options' => array('attr' => ['placeholder' => 'Please repeat your password', 'class' => 'form-control border-input'],'label' => 'Repeat Password')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
//            'allow_extra_fields' => true,
        ));
    }
}