<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\UserMedia;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ArrayToObjectTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms a array to object
     */
    public function transform($media)
    {
        if (null === $media) {
            return '';
        }

        return $media->getId();
    }

    public function reverseTransform($mediaArray)
    {
        // no issue number? It's optional, so that's ok
        if (!$mediaArray) {
            return;
        }

        $media = new UserMedia();
        $media->setImageFile($mediaArray);
        return $media;
    }
}