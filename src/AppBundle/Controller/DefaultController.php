<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Business;
use AppBundle\Entity\GoogleEvent;
use AppBundle\Entity\User;
use AppBundle\Exceptions\RestClientException;
use AppBundle\Helper\GradeUsApi;
use AppBundle\Repository\SearchEngineRankResultRepository;
use AppBundle\Service\FacebookService;
use AppBundle\Service\GoogleService;
use AppBundle\Service\InstagramService;
use AppBundle\Service\RestClientService;
use AppBundle\Service\SeoRankService;
use Curl\Curl;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends BaseController
{
    /**
     * @Route("/test", name="clear-cache")
     */
    public function indexAction(Request $request)
    {
        /**
         * @var FacebookService $facebookService
         */
        $facebookService = $this->get('app.facebook.service');

        /**
         * @var Business $currentBusiness
         */
        $currentBusiness = $this->getCurrentBusiness($request);

        $facebookPost = $this->findOneBy('AppBundle:FacebookPost', ['id' => 321]);

        $facebookService->getComments($facebookPost);

        return new Response();
    }

    private function clearCache($env)
    {
        $kernel = $this->get('kernel');
        $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $application->setAutoExit(false);
        $options = array('command' => 'cache:clear', "--env" => $env, '--no-warmup' => true);
        $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }
}
