<?php

namespace ContaoEstateManager\EstateManager\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use ContaoEstateManager\EstateManagerRead;

/**
 * Handles the EstateManager api routes.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class EstateManagerController extends Controller
{
    /**
     * Runs the command scheduler. (READ)
     *
     * @return JsonResponse
     */
    public function readAction($version, $module, $id)
    {
        $this->container->get('contao.framework')->initialize();

        $controller = new EstateManagerRead();

        return $controller->run($module, $id);
    }
}
