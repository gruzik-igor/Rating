<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\SignInForm;
use AppBundle\Form\SignUpForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthorizationController extends Controller
{
    /**
     * @Route("/authorization", name="authorization")
     */
    public function indexAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $form = $this->createForm(SignInForm::class);
        if ($error) {
            $formError = new FormError($error->getMessage());
            $form->addError($formError);
        }

        $response = $this->render('@App/security/sign-in.html.twig', ['form' => $form->createView()]);

        $response->headers->setCookie(new Cookie('business', null, time() - 3600));

        return $response;
    }

    /**
     * @Route("/sign-up", name="sign-up")
     */
    public function signUpAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $user = new User();

        $form = $this->createForm(SignUpForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $request->getMethod() ===  'POST') {
            $user->setListings(1);
            $user->setUsername($user->getEmail());
            $user->setSocialPosts(1);
            $user->setMessages(1);
            $user->setSeoRank(1);
            $user->setRole('ROLE_USER');

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            /**
             * @var GuardAuthenticatorHandler $guardAuthenticatorHandler
             */
            $guardAuthenticatorHandler = $this->get('security.authentication.guard_handler');

            $response = $guardAuthenticatorHandler->authenticateUserAndHandleSuccess($user, $request, $this->get('form_authenticator'), 'main');
        }
        else {
            $response = $this->render('@App/security/sign-up.html.twig', ['form' => $form->createView()]);
        }

        $response->headers->setCookie(new Cookie('business', null, time() - 3600));

        return $response;
    }

    /**
     * @Route("/logout", name="logout")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logoutAction()
    {
        $response = $this->redirectToRoute('authorization');

        return $response;
    }
}
