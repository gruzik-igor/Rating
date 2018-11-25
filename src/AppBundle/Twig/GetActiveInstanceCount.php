<?php


namespace AppBundle\Twig;



use Doctrine\ORM\EntityManagerInterface;


class GetActiveInstanceCount extends \Twig_Extension
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('activeInstanceCount', array($this, 'activeInstanceCount')),
        );
    }

    public function activeInstanceCount()
    {
        return $this->em->getRepository('AppBundle:Instance')->getActiveInstanceCount();
    }


}