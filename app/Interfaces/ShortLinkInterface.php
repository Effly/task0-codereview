<?php

namespace App\Interfaces;

interface ShortLinkInterface
{
    public function createShortLink($data): array;
    public function getStatsByShortLink($shortLink): array;
    public function getStats(): object;
}
