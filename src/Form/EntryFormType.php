<?php
/**
 * Created by PhpStorm.
 * User: a.herking
 * Date: 22.08.2019
 * Time: 14:04
 */

namespace App\Form;

use App\Entity\Entry;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class EntryFormType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        'data_class' => Entry::class,
            'csrf_protection' => false,

        ]);
    }

    public function getBlockPrefix()
    {
        return 'entry';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('solution')
            ->add('workflow')
            ->add('error')
            ->add('tagID');

    }
}