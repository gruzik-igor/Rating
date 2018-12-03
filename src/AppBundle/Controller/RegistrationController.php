<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/registration", name="registration")
     * @param UserPasswordEncoderInterface $encoder
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registrationAction(UserPasswordEncoderInterface $encoder, Request $request)
    {

        $user = new User();

        $form = $this->createForm(RegistrationForm::class, $user);

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted() && $request->getMethod() === 'POST') {

            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);

            $em->flush();

            return $this->redirectToRoute('dashboard');
        }
        return $this->render('@App/Registration/registration.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
