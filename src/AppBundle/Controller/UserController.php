<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\EditUserForm;
use AppBundle\Form\RegistrationForm;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class UserController extends Controller
{
    /**
     * @Route("/users", name="users")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */

    public  function usersListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('@App/dashboard/users/users.html.twig',['users' => $users]);
    }

    /**
     * @Route("/edit-user/{id}", name="user.edit")
     * @ParamConverter("user", class="AppBundle\Entity\User")
     * @param User $user
     */

    public  function editUserAction(Request $request , User $user, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(EditUserForm::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users');
        }


        return $this->render('@App/dashboard/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

}
