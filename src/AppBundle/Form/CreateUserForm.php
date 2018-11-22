<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreateUserForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['attr' => ['placeholder' => 'Enter your name', 'class' => 'col-md-4 form-control border-input'], 'label' => 'Username: '])
            ->add('fullName', TextType::class, ['attr' => ['placeholder' => 'Enter your fullName', 'class' => 'col-md-4 form-control border-input'], 'label' => 'fullName: '])
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'Please enter your email', 'class' => 'col-md-4 form-control border-input'], 'label' => 'E-mail: '])
            ->add('password', PasswordType::class, [ 'property_path' => 'plainPassword', 'attr' => ['placeholder' => 'Enter password', 'class' => 'col-md-4 form-control border-input'], 'label' => 'Password: '])
            ->add('contactPhone', NumberType::class, ['attr' => ['placeholder' => 'Enter phone number in format +1(111)111-11-11','class' => 'col-md-4 form-control border-input'],'label' => 'Contact phone: '])
            ->add('fullName', TextType::class, ['attr' => ['placeholder' => 'Enter your fullName', 'class' => 'col-md-4 form-control border-input'], 'label' => 'fullName: '])
            ->add('role', HiddenType::class, ['attr' => ['value' => 'ROLE_MA']])
            ->add('primaryLanguage', ChoiceType::class, ['attr' => ['class' => 'col-md-4'],
                'choices'  => array(
                    'English' => 'english',
                    'Germany' => 'germany',
                    'Ukraine' => 'ukrainian',
                ),])
            ->add('photo', FileType::class, ['label' => 'Company logo: ']);
//            ->add('Add user', SubmitType::class);


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
