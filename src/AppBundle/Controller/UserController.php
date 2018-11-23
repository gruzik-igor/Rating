<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\UserForm;
use AppBundle\Entity\User;


class UserController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     *
     */
    public function registrationAction(Request $request)
    {
        $user = new User ();
        $form = $this->createForm(UserForm::class, $user, ['validation_groups' => ['registration']]);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted() && $request->getMethod() === 'POST') {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            dump($data);die;
            $em->persist($user);
            $em->flush();
        }
//        return $this->render('@App/signup/signup.html.twig', [
//            'form' => $form->createView(),
//        ]);
        return $this->render('@App/user/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     //test route
    /**
     * @Route("/user/{user}", name="user")
     */
    public function userAction(User $user , Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:User');
//        var_dump($repository->findBy(["username" => 'igor'])); die;
//        var_dump($user); die;
    }



}
