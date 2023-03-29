<?php

namespace App\Form;

use App\Entity\Cafe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CafeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Coffee shop name"
            ])
            ->add('pictureFile', FileType::class, [
                'label' => "Add a picture",
                'required' => true
            ])
            ->add('box', TextType::class)
            ->add('number', IntegerType::class)
            ->add('street', TextType::class)
            ->add('zipCode', IntegerType::class)
            ->add('city', TextType::class)
            ->add('country', CountryType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cafe::class,
        ]);
    }
}
