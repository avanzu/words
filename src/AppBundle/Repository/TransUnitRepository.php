<?php
/**
 * TransUnitRepository.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Project;
use AppBundle\Entity\TransUnit;
use AppBundle\Localization\SimpleMessage;
use Components\Localization\IMessage;
use Components\Model\Completion;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

/**
 * Class TransUnitRepository
 */
class TransUnitRepository extends ResourceRepository
{

    /**
     * @return array
     */
    public function fetchCatalogues()
    {
        return $this
            ->createQueryBuilder('trans_unit')
            ->select('trans_unit.catalogue')
            ->distinct(true)
            ->addOrderBy('trans_unit.catalogue')
            ->getQuery()
            ->getScalarResult()
            ;
    }

    /**
     * @return array
     */
    public function fetchLanguages()
    {
        return $this
            ->createQueryBuilder('trans_unit')
            ->join('trans_unit.translations', 'translations')
            ->select('translations.locale', 'count(translations.locale) as nbTranslations')
            ->groupBy('translations.locale')
            ->addOrderBy('nbTranslations', 'DESC')
            ->getQuery()
            ->getScalarResult()
            ;

    }

    /**
     * @param string $unitAlias
     * @param string $valueAlias
     *
     * @return string
     */
    private function getSimpleMessageFields($unitAlias = 'trans_unit', $valueAlias = 'translations')
    {
        return strtr(
            implode(
                ', ',
                [
                    '{trans_unit}.key',
                    '{trans_unit}.key',
                    '{trans_unit}.key',
                    '{translations}.content',
                    '{trans_unit}.sourceString',
                    '{trans_unit}.description',
                    '{translations}.state',
                ]
            ),
            [
                '{trans_unit}' => $unitAlias,
                '{translations}' => $valueAlias,
            ]
        );
    }

    /**
     * @param        $locale
     * @param        $catalogue
     * @param string $project
     *
     * @return IMessage[]|SimpleMessage[]
     */
    public function fetchTranslations($locale, $catalogue, $project = Project::__DEFAULT)
    {
        $builder = $this
            ->createQueryBuilder('trans_unit')
            ->join('trans_unit.translations', 'translations')
            ->where('trans_unit.catalogue = :catalogue')
            ->andWhere('translations.locale = :locale')
            ->setParameters(['catalogue' => $catalogue, 'locale' => $locale])
            ->select(
                sprintf(
                    'new %s(%s)',
                    SimpleMessage::class,
                    $this->getSimpleMessageFields()
                )
            )
            ;

        return $this->joinProject($builder, $project)->getQuery()->getResult();
    }

    /**
     * @param $id
     * @param $locale
     *
     * @return IMessage
     */
    public function fetchMessage($id, $locale)
    {
        $builder = $this->createQueryBuilder('trans_unit')
            ->leftJoin('trans_unit.translations', 'translations', Join::WITH, 'translations.locale = :locale' )
            //->andWhere('translations.locale = :locale')
            ->andWhere('trans_unit.id = :id')
            ->setParameters(['locale' => $locale, 'id' => $id])
            ->select(
                sprintf(
                    'new %s(%s)',
                    SimpleMessage::class,
                    $this->getSimpleMessageFields()
                )
            );

        return current($builder->getQuery()->getResult());

    }

    /**
     * @param QueryBuilder $builder
     * @param string       $project
     *
     * @return mixed
     */
    protected function joinProject($builder, $project = Project::__DEFAULT)
    {
        if ($project === Project::__DEFAULT) {
            return $builder
                ->join('trans_unit.project', 'project')
                ->andWhere('project.canonical = :project')
                ->setParameter('project', $project)
                ;
        }

        return $builder
            ->join('trans_unit.project', 'common')
            ->andWhere('common.canonical = :common')
            ->setParameter('common', Project::__DEFAULT)
            ->leftJoin(Project::class, 'project', 'WITH', 'project.canonical = :canonical')
            ->leftJoin(
                TransUnit::class,
                'project_unit',
                'WITH',
                'project_unit.project = project.id '
                .'and trans_unit.key = project_unit.key '
                .'and trans_unit.catalogue = project_unit.catalogue'
            )
            ->leftJoin('project_unit.translations', 'project_values', 'WITH', 'project_values.locale = :locale')
            ->setParameter('canonical', $project)
            ->select(
                sprintf(
                    'new %s('
                    .'trans_unit.key,'
                    .'trans_unit.key,'
                    .'trans_unit.sourceString,'
                    .'project_values.content,'
                    .'trans_unit.sourceString,'
                    .'trans_unit.description,'
                    .'project_values.state)',
                    SimpleMessage::class
                )
            )
            ;

    }

    /**
     * @param        $locale
     * @param        $catalogue
     * @param string $project
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getTranslatableBuilder($locale, $catalogue, $project = Project::__DEFAULT)
    {
        $builder = $this
            ->createQueryBuilder('trans_unit')
            ->leftJoin('trans_unit.translations', 'translations', 'WITH', 'translations.locale = :locale')
            ->where('trans_unit.catalogue = :catalogue')
            ->setParameters(['catalogue' => $catalogue, 'locale' => $locale])
            ->select(
                sprintf(
                    'new %s(%s)',
                    SimpleMessage::class,
                    $this->getSimpleMessageFields()
                )
            )
        ;

        return $this->joinProject($builder, $project);

    }

    /**
     * @param        $locale
     * @param string $project
     *
     * @return mixed
     */
    public function getCompletion($locale, $project = Project::__DEFAULT)
    {


        $builder =$this
            ->createQueryBuilder('trans_unit')
            ->join('trans_unit.project', 'project', 'WITH', 'project.canonical = :common')
            ->setParameter('common', Project::__DEFAULT)
            ->leftJoin('trans_unit.translations', 'translations', 'WITH', 'translations.locale = :locale')
            ->select(
                sprintf(
                    'new %s(:locale, trans_unit.catalogue, count(trans_unit.key), count(translations.content))',
                    Completion::class
                )
            )
            ->groupBy('trans_unit.catalogue')
            ->distinct()
            ->setParameter('locale' , $locale);

        /** @var Completion[] $records */
        $records = $builder->getQuery()->getResult();


        if( Project::isDefault($project))  {
            return $records;
        }

        /*
         * -------------------------------------------------------------------------------------------------------------
         * In order to get the actual translation count from any other project besides the default project,
         * we need to issue another query and update the totals accordingly.
         * -------------------------------------------------------------------------------------------------------------
         */

        /**
         * Unfortunately, using indexBy will still return the records with numerical index.
         * We have to index them "by hand"
         *
         * @var Completion[] $indexed
         */
        $indexed    = [];
        foreach ($records as $record) {
            $indexed[$record->getCatalogue()] = $record;
        }

        $projectRecords = $this
            ->createQueryBuilder('unit')
            ->join('unit.project', 'project', 'WITH', 'project.canonical = :project')
            ->setParameter('project', $project)
            ->join('unit.translations', 'values', 'WITH', 'values.locale =:locale')
            ->setParameter('locale', $locale)
            ->where('unit.catalogue in (:catalogues)')
            ->setParameter('catalogues', array_keys($indexed))
            ->select('unit.catalogue, count(values.content) as nb_translated')
            ->groupBy('unit.catalogue')
            ->getQuery()
            ->getResult()
        ;


        foreach ($projectRecords as $projectRecord) {
            $catalogue    = $projectRecord['catalogue'];
            $nbTranslated = $projectRecord['nb_translated'];
            $indexed[$catalogue]->setTranslated($nbTranslated);
        }

        return array_values($indexed);


    }

    /**
     * @param        $key
     * @param        $catalogue
     * @param string $project
     *
     * @return mixed
     */
    public function findUnit($key, $catalogue, $project = Project::__DEFAULT) {

        $builder = $this
            ->createQueryBuilder('trans_unit')
            ->where('trans_unit.key = :key')
            ->andWhere('trans_unit.catalogue = :catalogue')
            ->setParameters(['key' => $key, 'catalogue' => $catalogue]);

        $canonical = $project instanceof  Project ? $project->getCanonical() : $project;

        $builder->join('trans_unit.project', 'project')
                ->andWhere('project.canonical = :canonical')
                ->setParameter('canonical', $canonical);


        return current($builder->getQuery()->getResult());
    }

}