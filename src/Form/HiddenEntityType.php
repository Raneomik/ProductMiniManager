<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 15/11/2018
 * Time: 04:24
 */

namespace App\Form;


use App\Form\DataTransformer\EntityToIdTransformer;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Entity hidden custom type class definition
 */
class HiddenEntityType extends AbstractType
{
    /**
     * @var ManagerRegistry $registry
     */
    private $registry;

    /**
     * Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $transformer = new EntityToIdTransformer($this->registry, $options['class'], $options['multiple']);
        $builder->addModelTransformer($transformer);
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setRequired(['class']);
        $resolver->setDefaults([
            'multiple'        => false,
            'data_class'      => null,
            'invalid_message' => 'The object does not exist.',
        ]);
        $resolver->setAllowedTypes('invalid_message', ['null', 'string']);
        $resolver->setAllowedTypes('multiple', ['boolean']);
    }


    /**
     * @inheritDoc
     */
    public function getParent() : string
    {
        return HiddenType::class;
    }

    /**
     * @inheritDoc
     */
    public function getName() : string
    {
        return HiddenEntityType::class;
    }
}