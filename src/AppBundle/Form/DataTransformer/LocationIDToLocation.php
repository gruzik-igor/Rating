<?php


namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Location;
use AppBundle\Exceptions\LocationException;
use AppBundle\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class LocationIDToLocation implements DataTransformerInterface
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    public function transform($value)
    {
        if ($value instanceof Location) {
            $response = $value->getId();
        } else {
            $response = $value;
        }

        return $response;
    }


    public function reverseTransform($value)
    {
        /**
         * @var LocationRepository $repository
         */
        $repository = $this->entityManager->getRepository('AppBundle:Location');

        if (is_numeric($value)) {
            $result = $repository->findOneById($value);
        }else {
            $result = $repository->getLocationByName($value);
        }

        if (empty($result)) {
            throw new LocationException('The entered location is incorrect', 422, 422);
        }

        return $result;
    }
}