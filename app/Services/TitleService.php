<?php


namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use App\Interfaces\TitleInterface;
use Illuminate\Support\Facades\Log;

class TitleService implements TitleInterface
{


    public function getTitle($long_url): string
    {

        try {
            $crawler = new Crawler(null, $long_url);
            $crawler->addHtmlContent(file_get_contents($long_url));
            return $crawler->filter('title')->text();
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
