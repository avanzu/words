<?php
/**
 * IMessageLoader.php
 * words
 * Date: 07.01.18
 */

namespace Components\Localization;


interface IMessageLoader
{
    public function loadCatalogue($file);
}