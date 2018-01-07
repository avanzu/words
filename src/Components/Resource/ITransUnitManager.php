<?php
/**
 * ITransUnitManager.php
 * words
 * Date: 07.01.18
 */

namespace Components\Resource;


use Components\Localization\IMessageCatalogue;
use Components\Model\TransUnit;

interface ITransUnitManager
{
    /**
     * @param $key
     * @param $catalogue
     * @param $project
     *
     * @return TransUnit
     */
    public function loadOrCreate($key, $catalogue, $project);

    /**
     * @param $key
     * @param $catalogue
     * @param $project
     *
     * @return TransUnit|null
     */
    public function lookup($key, $catalogue, $project);

    /**
     * @return array
     */
    public function loadCatalogues();

    /**
     * @return array
     */
    public function loadLanguages();

    /**
     * @param      $locale
     * @param      $catalogue
     * @param null $project
     *
     * @return IMessageCatalogue
     */
    public function loadTranslations($locale, $catalogue, $project = null);
}