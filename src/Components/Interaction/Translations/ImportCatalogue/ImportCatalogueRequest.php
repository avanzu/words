<?php
/**
 * ImportCatalogueRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\ImportCatalogue;


use Components\Infrastructure\Request\IRequest;
use Components\Localization\IMessageCatalogue;
use Components\Model\Project;

class ImportCatalogueRequest implements IRequest
{

    /**
     * @var  Project
     */
    protected $project;

    /**
     * @var IMessageCatalogue
     */
    protected $catalogue;

    /**
     * ImportCatalogueRequest constructor.
     *
     * @param IMessageCatalogue $catalogue
     * @param Project|null      $project
     */
    public function __construct( IMessageCatalogue $catalogue,  $project)
    {
        $this->project   = $project;
        $this->catalogue = $catalogue;
    }


    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return IMessageCatalogue
     */
    public function getCatalogue()
    {
        return $this->catalogue;
    }

    /**
     * @param IMessageCatalogue $catalogue
     *
     * @return $this
     */
    public function setCatalogue($catalogue)
    {
        $this->catalogue = $catalogue;

        return $this;
    }

}