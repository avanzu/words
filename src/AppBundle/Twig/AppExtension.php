<?php
/**
 * AppExtension.php
 * words
 * Date: 11.01.18
 */

namespace AppBundle\Twig;


use Twig\TwigFilter;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new TwigFilter('colorize', [$this, 'colorize'])
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

}