<?php
/**
 * ITranslator.php
 * restfully
 * Date: 26.09.17
 */

namespace Components\Localization;


interface ITranslator
{
    /**
     * @param        $token
     * @param array  $arguments
     * @param string $catalog
     *
     * @return string
     */
    public function translate($token, array $arguments = [], $catalog='messages');

    /**
     * @param        $token
     * @param        $count
     * @param array  $arguments
     * @param string $catalog
     *
     * @return string
     */
    public function pluralize($token, $count, array $arguments = [], $catalog='messages');
}