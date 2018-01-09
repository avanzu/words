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

    /**
     * @param     $locale
     * @param     $catalogue
     * @param     $project
     * @param int $offset
     * @param int $limit
     *
     * @return ResourceCollection
     */
    public function getTranslatables($locale, $catalogue, $project = null, $offset = 0, $limit = 10);

    /**
     * @param      $locale
     * @param      $catalogue
     * @param null $project
     *
     * @return mixed
     */
    public function getCompletion($locale, $catalogue, $project = null);
}