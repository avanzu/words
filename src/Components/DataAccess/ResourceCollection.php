<?php
/**
 * ResourceCollection.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\DataAccess;


/**
 * Class ResourceCollection
 */
class ResourceCollection implements Collection
{
    /**
     * @var \Traversable|\Countable
     */
    protected $items;
    /**
     * @var int
     */
    protected $limit;
    /**
     * @var int
     */
    protected $offset;
    /**
     * @var
     */
    private $total;

    /**
     * ResourceCollection constructor.
     *
     * @param \Traversable $items
     * @param              $total
     * @param int          $limit
     * @param int          $offset
     */
    public function __construct(\Traversable $items, $total, $limit = 10, $offset = 0) {
        $this->items  = $items;
        $this->limit  = $limit;
        $this->offset = $offset;
        $this->total  = $total;
    }

    /**
     * @return \Countable|\Traversable
     */
    public function getItems()
    {
        return iterator_to_array($this->items);
    }

    /**
     * @return mixed
     */
    public function getTotalCount()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getItemCount()
    {
        return count($this->getItems());
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    public function hasNext()
    {
        return (($this->offset + $this->limit) < $this->total);
    }

    public function hasPrevious()
    {
        return ($this->offset > 0);
    }

    public function getNextOffset()
    {
        return min($this->total, $this->offset + $this->limit);
    }
    public function getPreviousOffset()
    {
        return max(0 , $this->offset - $this->limit);
    }
}