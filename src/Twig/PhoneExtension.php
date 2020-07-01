<?php


namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PhoneExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('phone', [$this, 'normalize']),
        ];
    }

    public function normalize(string $stringToLower)
    {
        $unwantedArray = array('+33'=>'0', ' (0)' => '', ' ' => '');
        return wordwrap(strtr($stringToLower, $unwantedArray), 2, ' ', true);
    }
}
