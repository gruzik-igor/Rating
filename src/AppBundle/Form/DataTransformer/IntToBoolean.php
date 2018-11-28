<?php


namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class IntToBoolean implements DataTransformerInterface
{

    public function transform($value)
    {
        return boolval($value);
    }


    public function reverseTransform($value)
    {
        return intval($value);
    }
}