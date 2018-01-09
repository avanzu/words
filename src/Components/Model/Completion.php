<?php
/**
 * Completion.php
 * words
 * Date: 09.01.18
 */

namespace Components\Model;


class Completion
{

    protected $language;

    protected $catalogue;

    protected $total;

    protected $translated;

    /**
     * Completion constructor.
     *
     * @param $language
     * @param $catalogue
     * @param $total
     * @param $translated
     */
    public function __construct($language, $catalogue, $total, $translated)
    {
        $this->language   = $language;
        $this->catalogue  = $catalogue;
        $this->total      = $total;
        $this->translated = $translated;
    }

    public function getPercentCompleted()
    {
        return floor(($this->translated / $this->total) * 100);
    }


    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCatalogue()
    {
        return $this->catalogue;
    }

    /**
     * @param mixed $catalogue
     *
     * @return $this
     */
    public function setCatalogue($catalogue)
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     *
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTranslated()
    {
        return $this->translated;
    }

    /**
     * @param mixed $translated
     *
     * @return $this
     */
    public function setTranslated($translated)
    {
        $this->translated = $translated;

        return $this;
    }


}