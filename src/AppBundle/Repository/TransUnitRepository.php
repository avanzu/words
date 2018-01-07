<?php
/**
 * TransUnitRepository.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Repository;


use AppBundle\Localization\SimpleMessage;

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
            ->addOrderBy('nbTranslations')
            ->getQuery()
            ->getScalarResult()
            ;

    }

    /**
     * @param      $locale
     * @param      $catalogue
     * @param null $project
     *
     * @return SimpleMessage[]
     */
    public function fetchTranslations($locale, $catalogue, $project = null)
    {
        $builder = $this
            ->createQueryBuilder('trans_unit')
            ->join('trans_unit.translations', 'translations')
            ->where('trans_unit.catalogue = :catalogue')
            ->andWhere('translations.locale = :locale')
            ->setParameters(['catalogue' => $catalogue, 'locale' => $locale])
            ->select(
                sprintf('new %s(trans_unit.key, trans_unit.key, translations.content, trans_unit.key, trans_unit.description)', SimpleMessage::class)
            )

            ;
        if( $project ) {
            $builder
                ->join('trans_unit.project', 'project')
                ->andWhere('project.canonical = :project')
                ->setParameter('project' , $project);
        }

        return $builder->getQuery()->getResult();
    }

}