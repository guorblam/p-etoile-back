<?php
namespace AppBundle\Form\Type;

use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DomaineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('domaine', TextType::class, [
            'description' => "Domaine"
        ]);
        $builder->add('trusted', BooleanType::class, [
            'description' => "trusted ou non"
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Domaine',
            'csrf_protection' => false
        ]);
    }
}