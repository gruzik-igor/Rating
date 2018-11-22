<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class InstanceForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['attr' => ['placeholder' => 'Enter instance name without spaces'], 'label' => 'Name: '])
            ->add('domainName', TextType::class, ['attr' => ['placeholder' => 'Enter domain name for marketing agency'], 'label' => 'Domain name: '])
            ->add('licenseRate', MoneyType::class, ['attr' => ['placeholder' => 'Enter license rate'], 'label' => 'License rate: ', 'currency' => 'USD'])
            ->add('licenseIssued', NumberType::class, ['attr' => ['placeholder' => 'Enter license issued'], 'label' => 'License issued: '])
            ->add('user', EntityType::class, array(
                'class' => User::class,
                'choice_label' => 'username',
            ),['label' => 'User: ']);
        //->add('submit', SubmitType::class, ['attr' => [ 'class' => 'btn btn-success text-right'],'label' => 'Create']);


    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_instance';
    }
}
