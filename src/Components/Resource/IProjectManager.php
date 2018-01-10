<?php
/**
 * IProjectManager.php
 * words
 * Date: 09.01.18
 */

namespace Components\Resource;

use Components\Model\Project;

interface IProjectManager
{
    /**
     * @param $slug
     *
     * @return Project|null
     */
    public function loadProjectBySlug($slug);

    /**
     * @return mixed
     */
    public function loadProjects();

    /**
     * @param $id
     *
     * @return null|object
     */
    public function find($id);

    /**
     * @param $candidate
     *
     * @return Project|null
     */
    public function getProject($candidate);
}