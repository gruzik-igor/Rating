<?php


namespace AppBundle\Twig;



use Doctrine\ORM\EntityManagerInterface;


class GetIssuedLicenseCount extends \Twig_Extension
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('issuedLicenseCount', array($this, 'issuedLicenseCount')),
        );
    }

    public function issuedLicenseCount()
    {
        return $this->em->getRepository('AppBundle:Instance')->getIssuedLicenseCount();
    }

}