<?php

namespace ContaoEstateManager\EstateManager\Controller;

use Contao\CoreBundle\Framework\ContaoFramework;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use ContaoEstateManager\EstateManagerRead;

/**
 * Handles the EstateManager api routes.
 *
 * @Route(defaults={"_scope" = "frontend"})
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class EstateManagerController extends AbstractController
{
    private ContaoFramework $framework;

    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    /**
     * Runs the command scheduler. (READ)
     *
     * @Route("/api/estatemanager/v{version}/{module}/{id}", name="glossary_item_json", defaults={"id" = null})
     */
    public function readAction(int $version, string $module, $id): JsonResponse
    {
        $this->framework->initialize();

        $controller = new EstateManagerRead();

        return $controller->run($module, $id);
    }
}
