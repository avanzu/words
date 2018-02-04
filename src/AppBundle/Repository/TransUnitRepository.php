<?php
/**
 * TransUnitRepository.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Repository;


use AppBundle\Entity\TransUnit;
use AppBundle\Localization\SimpleMessage;
use Components\Localization\IMessage;
use Components\Model\Completion;
use Components\Model\Project;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class TransUnitRepository extends ResourceRepository
{

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
                '{translations}' => $valueAlias
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
     * @param null $project
     *
     * @return mixed
     */
    protected function joinProject($builder, $project = Project::__DEFAULT)
    {
        if( ! $project ) {
            return $builder->andWhere('trans_unit.project is null');
        }
        return $builder
            ->leftJoin('trans_unit.project', 'project')
            ->andWhere('project.canonical in (:project)')
            ->setParameter('project' , array_unique([$project, Project::__DEFAULT]))
            ;
    }

    /**
     * @param      $locale
     * @param      $catalogue
     * @param null $project
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

    public function getCompletion($locale, $project = Project::__DEFAULT)
    {
        $builder =$this
            ->createQueryBuilder('trans_unit')
            ->leftJoin('trans_unit.translations', 'translations', 'WITH', 'translations.locale = :locale')
            ->select(
                sprintf(
                    'new %s(:locale, trans_unit.catalogue, count(trans_unit.key), count(translations.content))',
                    Completion::class
                )
            )
            ->groupBy('trans_unit.catalogue')
            ->distinct()
            ->setParameters(['locale' => $locale]);

        return $this
            ->joinProject($builder, $project)
             ->getQuery()
             ->getResult()
            ;
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