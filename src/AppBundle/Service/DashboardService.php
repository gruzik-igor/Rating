<?php


namespace AppBundle\Service;


use AppBundle\Entity\Business;
use AppBundle\Entity\Rankings;
use AppBundle\Repository\RankingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class DashboardService
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }


    public function convertRankingsToChartData(Request $request, Business $business)
    {
        /**
         * @var RankingsRepository $repository
         */
        $repository = $this->em->getRepository('AppBundle:Rankings');


        if ($request->get('rankings') === 'month') {
            $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $rankings = $repository->findMonthlyByBusiness($business);
        } else {
            $labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            $rankings = $repository->findWeeklyByBusiness($business);
        }

        $response = $this->createChartData($rankings, $labels);

        return $response;
    }

    private function createChartData($rankings, $labels)
    {
        $keywordsChartData = [];

        /**
         * @var Rankings $ranking
         */
        foreach ($rankings as $ranking) {
            $dataset['Google'] = ['label' => 'Google', 'backgroundColor' => '#4285f4', 'borderColor' => '#4285f4', 'data' => [], 'fill' => false];
            $dataset['Google Local'] = ['label' => 'Google Local', 'backgroundColor' => '#dd4c40', 'borderColor' => '#dd4c40', 'data' => [], 'fill' => false];
            $dataset['Bing'] = ['label' => 'Bing', 'backgroundColor' => '#ffb901', 'borderColor' => '#ffb901', 'data' => [], 'fill' => false];
            $dataset['Yahoo'] = ['label' => 'Yahoo', 'backgroundColor' => '#4102b0', 'borderColor' => '#4102b0', 'data' => [], 'fill' => false];


            for ($i = 0; $i < count($labels); $i++) {
                $dataset['Google']['data'][$i] = 0;
                $dataset['Google Local']['data'][$i] = 0;
                $dataset['Bing']['data'][$i] = 0;
                $dataset['Yahoo']['data'][$i] = 0;
            }

            /**
             * @var Rankings $item
             */
            foreach ($rankings as $item) {
                if ($item->getKeyword() === $ranking->getKeyword()) {
                    if (count($labels) === 7) {
                        $key = $item->getCreationDate()->format('w') - 1;
                    } else {
                        $key = $item->getCreationDate()->format('n') - 1;
                    }

                    $dataset['Google']['data'][$key] = $item->getGoogle();
                    $dataset['Google Local']['data'][$key] = $item->getGoogleMaps();
                    $dataset['Bing']['data'][$key] = $item->getBing();
                    $dataset['Yahoo']['data'][$key] = $item->getYahoo();

                }
            }

            $keywordsChartData[$ranking->getKeyword()] = json_encode(['labels' => $labels, 'datasets' => array_values($dataset)]);

        }

        return $keywordsChartData;

    }
}