<?php
/**
 * TransUnitManager.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Manager;

use AppBundle\Localization\LazyMessageCatalogue;
use AppBundle\Repository\TransUnitRepository;
use Components\Model\TransUnit;
use Components\Resource\ITransUnitManager;


/**
 * Class TransUnitManager
 * @method TransUnitRepository getRepository
 */
class TransUnitManager extends ResourceManager implements ITransUnitManager
{

    /**
     * @param $key
     * @param $catalogue
     * @param $project
     *
     * @return TransUnit|null
     */
    public function lookup($key, $catalogue, $project)
    {
        return $this->getRepository()->findOneBy(['key' => $key, 'catalogue' => $catalogue, 'project' => $project]);
    }

    /**
     * @param $key
     * @param $catalogue
     * @param $project
     *
     * @return TransUnit
     */
    public function loadOrCreate($key, $catalogue, $project)
    {
        if( ! $unit = $this->lookup($key, $catalogue, $project)) {
            $unit = $this->createNew(['key' => $key, 'catalogue' => $catalogue, 'project' => $project]);
        }

        return $unit;
    }

    public function loadCatalogues()
    {
        return array_map(function($record){ return $record['catalogue']; }, $this->getRepository()->fetchCatalogues());
    }

    public function loadLanguages()
    {
        return array_map(function($record){ return $record['locale']; }, $this->getRepository()->fetchLanguages());
    }

    public function loadTranslations($locale, $catalogue, $project = null)
    {
        $factory = function() use($locale, $catalogue, $project ){

            foreach ($this->getRepository()->fetchTranslations($locale, $catalogue, $project) as $translation) {
                yield $translation->getId() => $translation;
            }
        };

        return new LazyMessageCatalogue($locale, $catalogue, $factory );
    }

}