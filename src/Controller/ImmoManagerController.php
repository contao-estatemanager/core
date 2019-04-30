<?php

namespace Oveleon\ContaoImmoManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Oveleon\ContaoImmoManagerBundle\ImmoManagerRead;

/**
 * Handles the immomanager api routes.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ImmoManagerController extends Controller
{
    /**
     * Runs the command scheduler. (READ)
     *
     * @return JsonResponse
     */
    public function readAction($version, $module, $id)
    {
        $this->container->get('contao.framework')->initialize();

        $controller = new ImmoManagerRead();

        return $controller->run($module, $id);
    }
}