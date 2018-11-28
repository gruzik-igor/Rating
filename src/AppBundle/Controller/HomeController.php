<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Business;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class HomeController extends BaseController
{
    /**
     * @Route("/", name="home")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        /**
         * @var Business $currentBusiness
         */
        $currentBusiness = $this->getCurrentBusiness($request);

        if ($this->isGranted('ROLE_MANAGER')) {
            $response = $this->redirectToRoute('manager-listings');
        } elseif ($currentBusiness instanceof Business) {
            $response = $this->redirectToRoute('listing-index');
        }
        elseif ($currentBusiness instanceof Business === false) {
            $response = $this->redirectToRoute('listing-index');
        }


        return $response;
    }

    /**
     * @Route("/privacy-policy", name="privacy-policy")
     */
    public function privacyPolicyAction(Request $request)
    {
        return $this->render('@App/other/privacy-policy.html.twig');
    }

    /**
     * @Route("/terms-of-use", name="terms-of-use")
     */
    public function termsOfUseAction(Request $request)
    {
        return $this->render('@App/other/terms-of-use.html.twig');
    }

}
