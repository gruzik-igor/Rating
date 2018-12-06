<?php


namespace AppBundle\Twig;



use Doctrine\ORM\EntityManagerInterface;


class GetSuspendedInstanceCount extends \Twig_Extension
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('suspendedInstanceCount', array($this, 'suspendedInstanceCount')),
        );
    }

    public function suspendedInstanceCount()
    {
        return $this->em->getRepository('AppBundle:Instance')->getSuspendedInstanceCount();
    }


}