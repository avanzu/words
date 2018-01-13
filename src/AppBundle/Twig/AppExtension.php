<?php
/**
 * AppExtension.php
 * words
 * Date: 11.01.18
 */

namespace AppBundle\Twig;


use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\ResourceBundle\LocaleBundle;
use Twig\TwigFilter;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new TwigFilter('colorize', [$this, 'colorize']),
            new TwigFilter('locale_name', [$this, 'getLocaleName'])
        ];
    }


    /**
     * @param        $percent
     * @param string $prefix
     *
     * @return string
     * @internal
     */
    public function colorize($percent, $prefix = '')
    {
        if( $percent > 75 ) return "$prefix-success";
        if( $percent > 50 ) return "$prefix-warning";
        if( $percent > 25)  return "$prefix-danger";
        return "$prefix-info";
    }

    /**
     * @param $locale
     *
     * @return null|string
     */
    public function getLocaleName($locale)
    {
        return Intl::getLocaleBundle()->getLocaleName($locale);
    }
}