<?php
/**
 * ExportCatalogueRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\ExportCatalogue;


use Components\DataAccess\CatalogueSelection;
use Components\Infrastructure\Request\IRequest;

class ExportCatalogueRequest implements IRequest
{
    /**
     * @var  CatalogueSelection
     */
    protected $selection;

    /**
     * @return CatalogueSelection
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * @param CatalogueSelection $selection
     *
     * @return $this
     */
    public function setSelection($selection)
    {
        $this->selection = $selection;

        return $this;
    }

}