<?php


namespace AppBundle\Twig;

class TimeAgo extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('time_ago', array($this, 'timeAgo')),
        );
    }

    public function timeAgo($datetime)
    {
        $time = time() - strtotime($datetime);

        $units = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($units as $unit => $val) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);

            return ($val == 'second') ? 'a few seconds ago' :
                (($numberOfUnits > 1) ? $numberOfUnits : 'a')
                . ' ' . $val . (($numberOfUnits > 1) ? 's' : '') . ' ago';
        }

        return '';
    }


}