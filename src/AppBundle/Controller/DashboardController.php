<?php

namespace AppBundle\Controller;

use AppBundle\Repository\LicenseRepository;
use Cronfig\Sysinfo\AbstractOs;
use Cronfig\Sysinfo\System;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;




class DashboardController extends BaseController
{
    /**
     * @Route("/", name="dashboard")
     */

    public function indexAction(Request $request)
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
     * @Route("/users", name="users")
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

//    // test routes
//    /**
//     * @Route("/user/info")
//     */
//    public function infoAction()
//    {
//        $name = 'Ivan Ivanenko';
//
//        return new Response('<html><body>Whoo: ' . $name . '</body></html>');
//    }
//
//    /**
//     * @Route("/user/add")
//     */
//
//    public function addAction()
//    {
//        $name = 'Add New User';
//
//        return new Response('<html><body>User: ' . $name . '</body></html>');
//    }


}
