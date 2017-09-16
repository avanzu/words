<?php
/**
 * Manager.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Resource;

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

}