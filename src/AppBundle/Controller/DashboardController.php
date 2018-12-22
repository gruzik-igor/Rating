<?php

namespace AppBundle\Controller;

use AppBundle\Repository\LicenseRepository;
use Cronfig\Sysinfo\AbstractOs;
use Cronfig\Sysinfo\System;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\HttpFoundation\Cookie;
use AppBundle\Entity\User;




class DashboardController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {


        return $this->render('@App/dashboard/index.html.twig',[
            'users' => $this->findBy('AppBundle:User', [])
        ]);
    }




    /**
     * @Route("/dashboards", name="dashboards")
     */

    public function dashboardAction(Request $request)
    {
        /**
         * @var $user User
         */
         $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

//       $em = $this->getDoctrine()->getManager();
//       $user = new User();
//
//       $user = $em->getRole();

//        echo '<pre>';
        //var_dump($request); die;
//        echo'</pre>';
       //$this->isGranted('ROLE_SUPER_ADMIN');

      // $userRole = $userRole->isGranted('ROLE_SUPER_ADMIN');;
        //dump($this);die;
        $userRole = $request->request;
     //var_dump($userRole);die;
        if($userRole == 'ROLE_SUPER_ADMIN')
        {
            $system = new System;
            $os = $system->getOs();

            $serverInfoService = $this->get('app.server_info.service');

            return $this->render('@App/dashboard/admin.html.twig', [
                'users' => $this->findBy('AppBundle:User', []),
                'meminfo'=> $serverInfoService->getSystemMemInfo(),
                'diskinfo' => $serverInfoService->getSystemHddInfo(),
                'cpuinfo' => $os->getLoadPercentage(AbstractOs::TIMEFRAME_1_MIN),
                'uptime' => $serverInfoService->getServerUptime(),
                'servinfo' => $serverInfoService->getSystemInfo(),
                'instances' => $this->findBy('AppBundle:Instance', [], []),
                'invoices' => $this->findBy('AppBundle:Invoice', []),
                'licenseRequest' => $this->findBy('AppBundle:LicenseRequest', [])
            ]);
        }
        elseif ($userRole == 'ROLE_MA')
        {
            $system = new System;
            $os = $system->getOs();

            $serverInfoService = $this->get('app.server_info.service');

            return $this->render('@App/dashboard/ma.html.twig', [
                'users' => $this->findBy('AppBundle:User', []),
                'meminfo'=> $serverInfoService->getSystemMemInfo(),
                'diskinfo' => $serverInfoService->getSystemHddInfo(),
                'cpuinfo' => $os->getLoadPercentage(AbstractOs::TIMEFRAME_1_MIN),
                'uptime' => $serverInfoService->getServerUptime(),
                'servinfo' => $serverInfoService->getSystemInfo(),
                'instances' => $this->findBy('AppBundle:Instance', [], []),
                'invoices' => $this->findBy('AppBundle:Invoice', []),
                'licenseRequest' => $this->findBy('AppBundle:LicenseRequest', [])
            ]);
        }

    }

    /**
     * @Route("/usersi", name="usersi")
     */

    public function usersAction(Request $request)
    {
        /**
         * @var LicenseRepository $repository
         */
//       $repository = $this->getRepository('AppBundle:License');
//        var_dump($request); di
        $userRole = $this->getUser()->getRole();
        //var_dump($this->getUser());die;
        if($userRole == 'ROLE_SUPER_ADMIN')
        {
            $system = new System;
            $os = $system->getOs();

            $serverInfoService = $this->get('app.server_info.service');

            return $this->render('@App/dashboard/users.html.twig', [
                'users' => $this->findBy('AppBundle:User', []),
                'meminfo'=> $serverInfoService->getSystemMemInfo(),
                'diskinfo' => $serverInfoService->getSystemHddInfo(),
                'cpuinfo' => $os->getLoadPercentage(AbstractOs::TIMEFRAME_1_MIN),
                'uptime' => $serverInfoService->getServerUptime(),
                'servinfo' => $serverInfoService->getSystemInfo(),
                'instances' => $this->findBy('AppBundle:Instance', [], []),
                'invoices' => $this->findBy('AppBundle:Invoice', []),
                'licenseRequest' => $this->findBy('AppBundle:LicenseRequest', [])
            ]);
        }


    }



    // test routes
    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {



        return $this->render('@App/admin/admin.html.twig',
            ['users' => $this->findBy('AppBundle:User', [])]);
    }

    /**
     * @Route("/test", name="test")
     */

    public function testAction(Request $request)
    {
        // берем користувача(юзера) з реквесту який нам прийшов і записуєм в змінну $user.
        $user = $this->getUser($request);

        // вставляємо кукі ім'я юзера.
       // $cookies = setcookie('user',$user->getUserName(),strtotime('now + 10 minutes'));

        // вставляємо id юзера.
       // $cookies = setcookie('id', $user->getId(), strtotime('now + 10 minutes'));

        //$cookies = setcookie('expired',strtotime('now + 10 minutes'));

        $cookies = setcookie('user',$user->getUserName(),strtotime('now + 10 minutes'),'~/','localhost:8000','true');

        // перевіряємо чи існує лічильник переглядів і ставим в кукі.
        $counter = isset($_COOKIE['counter']) ? $_COOKIE['counter'] : 0;
        $counter++;
        $cookies = setcookie('counter',$counter);

        $cookies_name = 'user';
        $cookies_value = 'user cookies';

        $user = $this->getUser($request);
        $id = $user->getId();
        $requests = $request->cookies;
//        $cookies =  setcookie($cookies_name, '', time() + 86400);

       // $cookies = setcookie('user');
        //$cookies = new Cookie('user', $user->getId(), strtotime('now + 10 minutes'));
        $server = $_SERVER;

        $session = $_SESSION;
        return $this->render('@App/dashboard/index.html.twig',
            ['user'=> $user,'cookies' => $cookies,'server' => $server,'session' => $session,'requests' => $requests, 'users' => $this->findBy('AppBundle:User', [])]);
    }


}
