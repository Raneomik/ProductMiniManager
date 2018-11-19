<?php

namespace App\Form;

use App\Entity\CartItem;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToCartType extends CartItemAbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add(
                'add_to_cart',
                SubmitType::class,
                [
                    'label' => 'cart.add',
                    'attr'  => [
                        'class' => 'w-75',
                    ],
                ]
            );
    }

}
