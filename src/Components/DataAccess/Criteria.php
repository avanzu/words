<?php
/**
 * Criteria.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\DataAccess;


class Criteria
{
    const CRITERIA_AND = 'AND';
    const CRITERIA_OR  = 'OR';

    /**
     * @var
     */
    protected $combination = self::CRITERIA_AND;
    /**
     * @var Criterion[]
     */
    protected $criteria = [];

    /**
     * Criteria constructor.
     *
     * @param string      $combination
     * @param Criterion[] $criteria
     */
    public function __construct(array $criteria = [], $combination = self::CRITERIA_AND)
    {
        $this->combination = $combination;
        $this->criteria    = $criteria;
    }

    /**
     * @return mixed
     */
    public function getCombination()
    {
        return $this->combination;
    }

    /**
     * @return Criterion[]
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param mixed $combination
     *
     * @return $this
     */
    public function setCombination($combination)
    {
        $this->combination = $combination;

        return $this;
    }

    /**
     * @param Criterion[] $criteria
     *
     * @return $this
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

}