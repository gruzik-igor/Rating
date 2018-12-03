<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\LogInForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {

        $errors = $authenticationUtils->getLastAuthenticationError();

        $lastUserName = $authenticationUtils->getLastUsername();

        $user = new User();

        $form = $this->createForm(LogInForm::class, $user);

        $form->handleRequest($request);



        return $this->render('@App/Login/login.html.twig', array(
            'errors' => $errors,
            'username' => $lastUserName,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction ()
    {

    }

}
