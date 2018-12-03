<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function findBy($entity, array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repository = $this->getRepository($entity);

        return $repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function getRepository($entity)
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository($entity);
    }
}