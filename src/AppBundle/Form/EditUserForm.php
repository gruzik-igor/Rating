<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditUserForm extends AbstractType
{
    public  function  buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['attr' => ['placeholder' => 'Enter your name', 'class' => 'form-control border-input'], 'label' => 'Username: '])
            ->add('fullName', TextType::class, ['attr' => ['placeholder' => 'Enter your fullName', 'class' => 'form-control border-input'], 'label' => 'fullName: '])
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'Please enter your email', 'class' => 'form-control border-input'], 'label' => 'E-mail: '])
//            ->add('role', HiddenType::class, ['attr' => ['value' => 'ROLE_SUPER_ADMIN']])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message'   => 'The password fields must match!',
                'required' => true,
                'first_options'  => array('attr' => ['placeholder' => 'Please enter your password', 'class' => 'form-control border-input'],'label' => 'Password'),
                'second_options' => array('attr' => ['placeholder' => 'Please repeat your password', 'class' => 'form-control border-input'],'label' => 'Repeat Password')))
            ->add('role',ChoiceType::class,[
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Moderator' => 'ROLE_MODERATOR',
                    'Admin' => 'ROLE_SUPER_ADMIN'
                ]

            ])
            ->add('submit', SubmitType::class,['attr' => ['class' => 'btn btn-success']]);

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