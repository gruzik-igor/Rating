<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Form\UserForm;
use AppBundle\Entity\User;


class UserController extends Controller
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registrationAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User ();
        $form = $this->createForm(UserForm::class, $user, ['validation_groups' => ['registration']]);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted() && $request->getMethod() === 'POST') {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            dump($user);die;
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }
        return $this->render('@App/signup/signup.html.twig', [
            'form' => $form->createView(),
        ]);
//        return $this->render('@App/user/registration.html.twig', [
//            'form' => $form->createView(),
//        ]);
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
