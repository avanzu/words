<?php
/**
 * ResourceCollection.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\DataAccess;


interface Collection
{
    /**
     * @return array
     */
    public function getItems();

    /**
     * @return int
     */
    public function getTotalCount();

    /**
     * @return int
     */
    public function getItemCount();

    /**
     * @return int|null
     */
    public function getLimit();

    /**
     * @return int|null
     */
    public function getOffset();
}