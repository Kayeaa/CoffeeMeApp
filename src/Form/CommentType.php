<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        //DATE, USER, CAFE AUTOMATIQUE
            ->add('cafe', CafeType::class)
            ->add('user', UserType::class)
            ->add('message', TextareaType::class, [
                'label' => 'Commentaire',
                'constraint' =>[new NotBlank()]
            ])
            ->add('Submit', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
