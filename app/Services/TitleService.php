<?php


namespace App\Services;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use App\Interfaces\TitleInterface;

class Crawler implements TitleInterface
{

    /**
     * @var \App\Services\Crawler
     */
    private $crawler;

    public function __construct(DomCrawler $crawler){
        $this->crawler = $crawler;
    }

    public function getTitle($html)
    {
        return $this->crawler->filter('title')->text();
    }
}
