<?php

namespace App\Repositories;

use App\Interfaces\ScrapRepositoryInterface;
use App\Services\InformationParser;

class ScrapRepository implements ScrapRepositoryInterface
{
    public function getInformation($link)
    {
        $url = parse_url($link);
        $informationParser = new InformationParser($link);

        switch($url['host']){
            case "www.amazon.com":
                return $informationParser->amazonProductInformation();
            case "www.ebay.com":
                return $informationParser->ebayProductInformation();
            default:
                null;
        }
    }
}
