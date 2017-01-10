<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class, [
            'description' => "Prénom de l'utilisateur"
        ]);
        $builder->add('lastname', TextType::class, [
            'description' => "Nom de l'utilisateur"
        ]);
        $builder->add('plainPassword', TextType::class, [
            'description' => "Mot de passe de l'utilisateur"
        ]);
        $builder->add('email', EmailType::class, [
            'description' => "email de l'utilisateur"
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'csrf_protection' => false
        ]);
    }
}