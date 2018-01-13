<?php
/**
 * ResourceCollection.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\DataAccess;

use Traversable;


/**
 * Class ResourceCollection
 */
class ResourceCollection implements Collection, \IteratorAggregate, IPager
{
    /**
     * @var \Traversable|\Countable|\IteratorAggregate
     */
    protected $items;
    /**
     * @var int
     */
    protected $limit;
    /**
     * @var int
     */
    protected $page;
    /**
     * @var
     */
    private $total;

    /**
     * ResourceCollection constructor.
     *
     * @param \Traversable|\IteratorAggregate|callable $items
     * @param                                          $total
     * @param int                                      $limit
     * @param int                                      $page
     */
    public function __construct( $items, $total, $limit = 10, $page = 1) {
        $this->items = $items;
        $this->limit = $limit;
        $this->page  = $page;
        $this->total = $total;
    }

    /**
     * @return \Countable|\Traversable
     */
    public function getItems()
    {
        if( is_callable($this->items)) {
            $this->items = call_user_func($this->items);
        }

        return $this->items;
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
    public function getPage()
    {
        return $this->page;
    }

    public function hasNext()
    {
        return (($this->page + $this->limit) < $this->total);
    }

    public function hasPrevious()
    {
        return ($this->page > 0);
    }

    public function getNextOffset()
    {
        return min($this->total, $this->page + $this->limit);
    }
    public function getPreviousOffset()
    {
        return max(0 , $this->page - $this->limit);
    }

    /**
     * Retrieve an external iterator
     *
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getItems());
    }

    public function getOffset()
    {
        return (($this->page-1)  * $this->limit);
    }
}