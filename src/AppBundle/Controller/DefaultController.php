<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\EditUserForm;
use AppBundle\Form\RegistrationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
       return $this->render('@App/dashboard/index.html.twig');
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */

    public  function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('@App/dashboard/users.html.twig',['users' => $users]);
    }

    /**
     * @Route("/edituser/{id}", name="user.edit")
     * @ParamConverter("user", class="AppBundle\Entity\User")
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */

    public  function editUserAction(Request $request ,User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(EditUserForm::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }


        return $this->render('@App/dashboard/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

}
