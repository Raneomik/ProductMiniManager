<?php

namespace App\Form\DataTransformer;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\PropertyAccess\PropertyAccess;

class EntityToIdTransformer implements DataTransformerInterface
{
    /** @var ManagerRegistry */
    protected $registry;

    /** @var string */
    protected $class;

    /** @var boolean */
    protected $multiple = false;
    /**
     * @param ManagerRegistry $registry
     * @param string          $class
     * @param bool            $multiple
     */
    public function __construct(ManagerRegistry $registry, string $class, bool $multiple = false)
    {
        $this->registry = $registry;
        $this->class = $class;
        $this->multiple = $multiple;
    }
    /**
     * @inheritdoc
     */
    public function transform($entity)
    {
        if (null === $entity) {
            return null;
        }
        if ($this->multiple && \is_array($entity)) {
            $value = [];
            foreach ($entity as $e) {
                $value[] = $e->getId();
            }
            $value = implode(',', $value);
        } else {
            $value = $entity->getId();
        }
        return $value;
    }
    /**
     * @inheritdoc
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }
        if ($this->multiple) {
            $ids = explode(',', $id);
            $result = $this->getRepository()->findBy(['id' => $ids] );
        } else {
            $result = $this->getRepository()->findOneBy(['id' => $id]);
            if (null === $result) {
                throw new TransformationFailedException(sprintf('Can\'t find entity of class "%s" id = "%s".', $this->class, $id));
            }
        }
        return $result;
    }
    /**
     * @return ObjectRepository
     */
    protected function getRepository(): ObjectRepository
    {
        return $this->registry->getRepository($this->class);
    }

}