<?php


namespace AppBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;

class FindBy extends \Twig_Extension
{


    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('findBy', array($this, 'findBy')),
        );
    }

    public function findBy($entity, array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repository = $this->em->getRepository($entity);

        return $repository->findBy($criteria, $orderBy, $limit, $offset);
    }


}