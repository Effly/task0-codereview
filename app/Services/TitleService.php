<?php


namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use App\Interfaces\TitleInterface;

class TitleService implements TitleInterface
{


    public function getTitle($long_url): string
    {
        $crawler = new Crawler(null,$long_url);

        $crawler->addHtmlContent(file_get_contents($long_url));
        return $crawler->filter('title')->text();
    }
}
