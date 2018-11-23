<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SignInForm;

class SecurityController extends Controller
{
    /**
     * @Route("/sign-in", name="sign-in")
     */
    public function indexAction()
    {
        $form = $this->createForm(SignInForm::class);

        return $this->render('@App/security/sign-in.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/logout", name="logout")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logoutActiot()
    {
        return $this->redirectToRoute('sign-in');
    }
}
