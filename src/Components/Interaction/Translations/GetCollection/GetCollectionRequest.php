<?php
/**
 * GetCollectionRequest.php
 * words
 * Date: 08.01.18
 */

namespace Components\Interaction\Translations\GetCollection;
use Components\Interaction\Resource\GetCollection\GetCollectionRequest as CollectionRequest;

class GetCollectionRequest extends CollectionRequest
{

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $catalogue;

    /**
     * @return string
     */
    public function getCatalogue()
    {
        return $this->catalogue;
    }

    /**
     * @param string $catalogue
     *
     * @return $this
     */
    public function setCatalogue($catalogue)
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

}