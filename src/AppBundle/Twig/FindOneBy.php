<?php


namespace AppBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;

class FindOneBy extends \Twig_Extension
{


    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('findOneBy', array($this, 'findOneBy')),
        );
    }

    public function findOneBy($entity, array $criteria)
    {
        $repository = $this->em->getRepository($entity);

        return $repository->findOneBy($criteria);
    }


}