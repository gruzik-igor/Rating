<?php


namespace AppBundle\Twig;


use AppBundle\Entity\Instance;

use Curl\Curl;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {


        return array(

            new TwigFilter('getUsageLicenseCount', array($this, 'getUsageLicenseCount')),
        );
    }

    public function getUsageLicenseCount(Instance $instance)
    {
        $apiUrl = 'api/businessesCount.json';
//            $curl = new Curl($instance->getDomain());
//            $curl->get($apiUrl);
//
//            $result = $curl->response;
        $result = json_decode(file_get_contents($apiUrl), true)['businessesCount'];

        return $result;
    }


}