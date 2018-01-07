<?php
/**
 * FileResource.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Localization;


class FileResource
{

    protected $fileName;
    protected $catalog;
    protected $locale;
    protected $extension;

    /**
     * FileResource constructor.
     *
     * @param $fileName
     *
     * @throws \Exception
     */
    public function __construct($fileName) {

        $this->fileName = $fileName;
        $baseName       = basename($fileName);
        $baseNameParts  = explode('.', $baseName);
        if( 3 !== count($baseNameParts) ) {
            throw new \Exception(sprintf('Invalid file name "%s". Expected format should be [catalog].[locale].[extension].', $baseName));
        }
        list($this->catalog, $this->locale, $this->extension) = $baseNameParts;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return mixed
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

}