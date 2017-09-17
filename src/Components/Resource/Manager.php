<?php
/**
 * Manager.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Resource;

use Components\DataAccess\Criteria;
use Components\Resource\Repository\Repository;
use Components\Resource\Validator\Result;
use Components\Resource\Validator\Validator;

/**
 * Class ResourceManager
 */
interface Manager
{
    /**
     * @param      $model
     * @param null $groups
     * @param null $constraints
     *
     * @return Result
     */
    public function validate($model, $groups = null, $constraints = null);

    /**
     * @param array $properties
     *
     * @return mixed
     */
    public function createNew($properties = []);

    /**
     * @param array|object $models
     * @param bool         $flush
     * @param null         $intent
     */
    public function save($models = [], $flush = true, $intent = null);

    /**
     * @param array|object $models
     * @param bool         $flush
     * @param null         $intent
     */
    public function remove($models = [], $flush = true, $intent = null);

    /**
     * @param       $model
     * @param array $properties
     *
     * @return mixed
     */
    public function initialize($model, $properties = []);

    /**
     * @param  int     $limit
     * @param  int     $offset
     * @param Criteria[] $criteria
     *
     * @return mixed
     */
    public function getCollection($limit, $offset = 0, $criteria = null);

    /**
     * @return Repository
     */
    public function getRepository();

    /**
     * @return Validator
     */
    public function getValidator();

    /**
     * @return string
     */
    public function getClassName();

    /**
     * @return void
     */
    public function startTransaction();

    /**
     * @return void
     */
    public function cancelTransaction();

    /**
     * @return void
     */
    public function commitTransaction();
}