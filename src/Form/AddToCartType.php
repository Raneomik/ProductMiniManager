<?php

namespace App\Form;

use App\Entity\CartItem;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add(
                'quantity',
                IntegerType::class,
                [
                    'label' => false,
                    'attr'  => [
                        'class' => 'w-50',
                    ],
                ]
            )
            ->add(
                'product',
                HiddenEntityType::class,
                [
                    'class' => Product::class,
                ]
            )
            ->add(
                'add_to_cart',
                SubmitType::class,
                [
                    'label' => 'cart.add',
                    'attr'  => [
                        'class' => 'w-50',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults(
            [
                'data_class' => CartItem::class,
            ]
        );
    }
}
