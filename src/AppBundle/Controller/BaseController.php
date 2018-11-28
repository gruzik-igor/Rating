<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Business;
use AppBundle\Entity\InstagramAccount;
use AppBundle\Entity\InstagramPost;
use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Form\InstagramAccountForm;
use AppBundle\Form\InstagramPostForm;
use AppBundle\Form\MessageForm;
use AppBundle\Repository\BusinessRepository;
use AppBundle\Repository\DataForSeoTaskRepository;
use AppBundle\Service\InstagramService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    public function getRepository($entity)
    {
        return $this->getDoctrine()->getRepository($entity);
    }

    public function findBy($entity, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        $repository = $this->getDoctrine()->getRepository($entity);

        return $repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy($entity, array $criteria)
    {
        $repository = $this->getDoctrine()->getRepository($entity);

        return $repository->findOneBy($criteria);
    }

    public function getCurrentBusiness(Request $request)
    {
        /**
         * @var BusinessRepository $repository
         */
        $repository = $this->getDoctrine()->getRepository('AppBundle:Business');

        return $repository->getCurrentBusiness($request, $this->getUser());
    }

    public function getBusinesses()
    {

        $businesses = $this->findBy('AppBundle:Business', ['user' => $this->getUser()->getId()]);

        return $businesses;
    }

    public function messageForm(Request $request, $type)
    {
        $message = new Message();
        $message->setBusiness($this->getCurrentBusiness($request));

        $message->setType($type);
        $formFactory = $this->get('form.factory');
        /**
         * @var FormBuilder $form
         */
        $form = $formFactory->createNamedBuilder($type, MessageForm::class);
        $form->setData($message);

        $messageForm = $form->getForm();

        $messageForm->handleRequest($request);


        if ($messageForm->isSubmitted() && $messageForm->isValid() && 'POST' == $request->getMethod()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($message);
            $em->flush();

        }

        return $messageForm;
    }

    public function instagramAccountForm(Request $request)
    {
        /**
         * @var InstagramService $instagramService
         */
        $instagramService = $this->get('app.instagram.service');

        $instagramAccount = new InstagramAccount();

        $instagramAccountForm = $this->createForm(InstagramAccountForm::class, $instagramAccount);

        $instagramAccountForm->handleRequest($request);


        if ($instagramAccountForm->isSubmitted() && $instagramAccountForm->isValid() && 'POST' == $request->getMethod()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($instagramAccount);
            $em->flush();


            $instagramService->scrapPosts($instagramAccount);
        }

        return $instagramAccountForm;
    }

    public function instagramPostForm(Request $request)
    {
        $instagramPost = new InstagramPost();

        $instagramPostForm = $this->createForm(InstagramPostForm::class, $instagramPost);

        $instagramPostForm->handleRequest($request);


        if ($instagramPostForm->isSubmitted() && $instagramPostForm->isValid() && 'POST' == $request->getMethod()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($instagramPost);
            $em->flush();
        }

        return $instagramPostForm;
    }

    public function getCSRFToken($html)
    {
        $first_step = explode('<meta name="csrf-token" content="', $html);
        $second_step = explode(' />', $first_step[1]);
        $csrf = str_replace('"', '', $second_step[0]);

        return $csrf;
    }

    public function notification($title, $message, $link)
    {
        $admin = $this->findOneBy('AppBundle:User', ['role' => 'ROLE_SUPER_ADMIN']);

        if ($admin instanceof User) {
            $manager = $this->get('mgilet.notification');
            $notif = $manager->createNotification($title);
            $notif->setMessage($message);
            $notif->setLink($link);

            $manager->addNotification(array($admin), $notif, true);
        }

    }

    public function getSiteSettings()
    {
        return $this->findOneBy('AppBundle:SiteSettings', ['id' => 1]);
    }

    public function getBusinessByType()
    {
        return $this->findBy('AppBundle:Business', ['user' => $this->getUser()->getId()])[0];
    }

    public function getParameterForAll(Request $request)
    {
        $currentBusiness = $this->getCurrentBusiness($request);
        $businesses = [];
        $googleAccount = null;

        if ($currentBusiness instanceof Business) {
            $businesses = $this->getBusinesses();
        }

        return [
            'businesses' => $businesses,
            'page' => $request->get('page', 1)
        ];
    }


}