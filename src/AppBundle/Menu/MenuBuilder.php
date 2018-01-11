<?php
/**
 * MenuBuilder.php
 * words
 * Date: 11.01.18
 */

namespace AppBundle\Menu;


use Components\Application\Runtime;
use Components\Model\Project;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    /**
     * @var  FactoryInterface
     */
    private $factory;
    /**
     * @var Runtime
     */
    private $runtime;

    /**
     * MenuBuilder constructor.
     *
     * @param FactoryInterface $factory
     * @param Runtime          $runtime
     */
    public function __construct(FactoryInterface $factory, Runtime $runtime) {
        $this->factory = $factory;
        $this->runtime = $runtime;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('Home', array('route' => 'app_homepage'));
        $menu->addChild('Projects', array('route' => 'app_projects_list'));

        if($project = $this->runtime->get('project') ) {
            $this->addProjectMenu($menu, $project, $options);
        }

        return $menu;
    }

    protected function addProjectMenu(ItemInterface $item, Project $project, array $options)
    {
        $parameters  = ['project' => $project->getCanonical()];
        $projectMenu = $item->addChild(
            (string)$project, [
                'route' => 'app_homepage_project',
                'routeParameters' => $parameters
            ]);

        $item->addChild('Translate', [
            'route'           => 'app_translation_translate_index',
            'routeParameters' => $parameters,
            'extras'          => [
                'routes' => [['pattern' =>'/app_translation_translate.+/']]
            ]
        ]);
        $item->addChild('New Translation', [
            'route'           => 'app_translations_create',
            'routeParameters' => $parameters,
        ]);
        $item->addChild('Upload catalogue', [
            'route'           => 'app_translation_file_upload',
            'routeParameters' => $parameters,
        ]);
        $item->addChild('Download catalogue', [
            'route'           => 'app_translation_file_select',
            'routeParameters' => $parameters,
        ]);


    }


}