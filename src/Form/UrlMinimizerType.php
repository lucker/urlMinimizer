<?php

namespace App\Form;

use App\Entity\UrlMinimizer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UrlMinimizerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url')
            ->add('minimizedUrl')
            ->add('lifeTime')
            ->add('clickCount')
            ->add('active')
            ->add('created')
            ->add('updated')
            ->add('lifeTimeEnded')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UrlMinimizer::class,
        ]);
    }
}
