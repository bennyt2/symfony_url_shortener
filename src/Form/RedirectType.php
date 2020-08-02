<?php

namespace App\Form;

use App\Entity\Redirect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RedirectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class, [
                'help' => 'Please include URL Protocol (e.g. http://, https://).',
            ])
            ->add('slug', TextType::class, [
                'help' => 'Can be 5-9 characters long. Leave blank to auto-generate a slug.',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create Redirect',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Redirect::class,
        ]);
    }
}
