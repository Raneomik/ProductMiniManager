<?php

namespace App\Form;

use App\Entity\CartItem;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateCartType extends CartItemAbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add(
                'update_cart',
                SubmitType::class,
                [
                    'label' => 'cart.update',
                    'attr'  => [
                        'class' => 'w-50',
                    ],
                ]
            );
    }

}
