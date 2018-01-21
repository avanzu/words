<?php
/**
 * TransUnitManager.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Manager;

use AppBundle\DataAccess\Pager;
use AppBundle\Localization\LazyMessageCatalogue;
use AppBundle\Repository\TransUnitRepository;
use Components\DataAccess\IPager;
use Components\DataAccess\ResourceCollection;
use Components\Model\Completion;
use Components\Model\TransUnit;
use Components\Resource\ITransUnitManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Pagerfanta\Adapter\DoctrineORMAdapter;


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

    /**
     * @return array
     */
    public function loadCatalogues()
    {
        return array_map(function($record){ return $record['catalogue']; }, $this->getRepository()->fetchCatalogues());
    }

    /**
     * @return array
     */
    public function loadLanguages()
    {
        return array_map(function($record){ return $record['locale']; }, $this->getRepository()->fetchLanguages());
    }

    /**
     * @param      $locale
     * @param      $catalogue
     * @param null $project
     *
     * @return LazyMessageCatalogue|\Components\Localization\IMessageCatalogue
     */
    public function loadTranslations($locale, $catalogue, $project = null)
    {
        $factory = function() use($locale, $catalogue, $project ){

            foreach ($this->getRepository()->fetchTranslations($locale, $catalogue, $project) as $translation) {
                yield $translation->getId() => $translation;
            }
        };

        return new LazyMessageCatalogue($locale, $catalogue, $factory );
    }

    /**
     * @param     $locale
     * @param     $catalogue
     * @param     $project
     * @param int $page
     * @param int $limit
     *
     * @return IPager
     */
    public function getTranslatables($locale, $catalogue, $project = null, $page = 1, $limit = 10)
    {
        $builder = $this->getRepository()->getTranslatableBuilder($locale, $catalogue, $project);
        /*
        $builder->setMaxResults($limit)->setFirstResult($offset);
        $pager = new Paginator($builder, true);
        $pager->setUseOutputWalkers(false);
        */

        $pager = new Pager(new DoctrineORMAdapter($builder, true, false));
        $pager->setMaxPerPage($limit)->setCurrentPage($page);
        return $pager;

        // return new ResourceCollection($pager, count($pager), $limit, $page);

    }

    /**
     * @param $id
     * @param $locale
     *
     * @return \Components\Localization\IMessage|false
     */
    public function getMessage($id, $locale) {
        return $this->getRepository()->fetchMessage($id, $locale);
    }

    /**
     * @param      $locale
     * @param null $project
     *
     * @return Completion
     */
    public function getCompletion($locale,  $project = null)
    {
        $result = $this->getRepository()->getCompletion($locale, $project);
        return $result;
    }


}