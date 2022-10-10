<?php

namespace App\Resolver;

use App\Entity\Announcements;

class ConvertToCurrentCurrencyResolver implements ConvertToCurrentCurrencyResolverInterface
{
    private GetExchangeRateInterface $rate;

    public function __construct(GetExchangeRateInterface $rate)
    {
        $this->rate = $rate;
    }

    public function convert(array $announcements): void
    {
        foreach ($announcements as $announcement) {
            /** @var Announcements $announcement */
            $announcement->setPriceGross($announcement->getPriceGross() / $this->rate->getEuroExchangeRate());
        }
    }

    public function convertOne(Announcements $announcement): void
    {
        $announcement->setPriceGross($announcement->getPriceGross() / $this->rate->getEuroExchangeRate());
    }
}