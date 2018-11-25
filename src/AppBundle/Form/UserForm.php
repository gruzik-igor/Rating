<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\IntToBoolean;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserForm extends AbstractType
{

    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['attr' => ['placeholder' => 'Enter your Name', 'class' => 'form-control border-input '],'label' => 'Username: '])
            ->add('fullName', TextType::class, ['attr' => ['placeholder' => 'Enter your FullName', 'class' => 'form-control border-input'], 'label' => 'FullName: '])
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'Please enter your email', 'class' => 'form-control border-input'], 'label' => 'E-mail: '])
            ->add('role', HiddenType::class, ['attr' => ['value' => 'ROLE_SUPER_ADMIN']])
            ->add('password', PasswordType::class, [ 'property_path' => 'plainPassword', 'attr' => ['placeholder' => 'Enter password', 'class' => 'form-control border-input'],'label' => 'Password: ']);
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
        return 'appbundle_user';
    }
}
