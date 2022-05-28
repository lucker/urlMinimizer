<?php

namespace App\Form;

use App\Entity\UrlMinimizer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UrlMinimizerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', UrlType::class)
            //->add('minimizedUrl')
            ->add('lifeTime', NumberType::class, [
                'label' => 'LifeTime in seconds'
            ])
            //->add('clickCount')
            //->add('active')
            //->add('created')
            //->add('updated')
            //->add('lifeTimeEnded')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UrlMinimizer::class,
        ]);
    }
}
