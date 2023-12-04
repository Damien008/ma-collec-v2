<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('money', [$this, 'formatMoney']),
            new TwigFunction('date', [$this, 'formatDate']),
        ];
    }


    public function formatMoney(string $lang): string
    {
        if($lang === 'en'){
            return '$';
        }else{
            return'€';
        }
    }

    public function formatPrice($price): string
    {
        return number_format($price, 0, ' ', ' ');
    }

    public function formatDate($date): string
    {
        return $date->format('d-m-Y');
    }
}