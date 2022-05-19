<?php

namespace ContaoEstateManager\EstateManager\Controller\Api;

use Contao\Config;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\FilesModel;
use Contao\Frontend;
use Contao\Image;
use Contao\System;
use Contao\Validator;
use ContaoEstateManager\EstateManager\Exception\ApiConnectionException;
use ContaoEstateManager\EstateManager\Exception\ApiMissingParameterException;
use ContaoEstateManager\EstateManager\Exception\ApiResponseException;
use ContaoEstateManager\FilterSession;
use ContaoEstateManager\ModuleRealEstate;
use ContaoEstateManager\SessionManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract Api Controller.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class AbstractApiController extends Frontend
{
    /**
     * Contao framework
     */
    private ContaoFramework $framework;

    /**
     * Current request
     */
    protected Request $request;

    /**
     * Current Module
     */
    protected ?ModuleRealEstate $objModule = null;

    /**
     * Constructor
     */
    public function __construct(ContaoFramework $framework, RequestStack $requestStack)
    {
        // Contao framework
        $this->framework = $framework;
        $this->framework->initialize();

        // Request
        $this->request = $requestStack->getCurrentRequest();

        // Verify connection
        $this->verifyConnection($this->request->get('key'));

        // Load the user object before calling the parent constructor
        $this->import('FrontendUser', 'User');

        parent::__construct();
    }

    /**
     * Verify API connection
     *
     * @throws ApiConnectionException
     */
    protected function verifyConnection(?string $key = null): void
    {
        if(!$key)
        {
            throw new ApiConnectionException('Missing access key. The connection could not be established.');
        }

        if($key !== Config::get('cemApiKey'))
        {
            throw new ApiConnectionException('The API key used is not valid. The connection could not be established.');
        }
    }

    /**
     * Apply filter for current request and return query parameters
     */
    protected function applyFilter(): ?array
    {
        // Check missing parameter
        $this->checkMissingParameter(['pageId', 'groups', 'filterMode']);

        // Get filter instance
        $objSessionFilter = SessionManager::getInstance();

        // Set page scope
        $objSessionFilter->setPage($this->request->get('pageId'));

        // ToDo: New Method for apply filtering by GET-Parameter instead of session
        //$objSessionFilter->setMode(SessionManager::MODE_REQUEST);

        // Return filter query
        return $objSessionFilter->getParameter(
            $this->request->get('groups')
        );
    }

    /**
     * Create a success response
     */
    protected function createResponse(?array $arrData = null): Response
    {
        $structure = [
            'status' => 'OK',
            'meta'   => [
                'total' => \is_array($arrData) ? count($arrData) : 0,
                'query' => $this->request->query->all()
            ],
            'results' => $arrData ?? []
        ];

        switch($this->request->get('format'))
        {
            case 'xml':
                // ToDo: XML Response
                throw new ApiResponseException('The XML format is currently not yet available.');
            default:
                return new JsonResponse($structure);
        }
    }

    /**
     * Checks if the passed parameters are present in the current request and returns missing parameters.
     */
    protected function checkMissingParameter(array $arrParameter): void
    {
        $requestKeys = $this->request->query->keys();

        // If the intersection of the parameters does not match, check which parameter is missing
        if(count(array_intersect($arrParameter, $requestKeys)) !== count($arrParameter) && !empty($requestKeys))
        {
            foreach ($arrParameter as $key)
            {
                if(!\in_array($key, $requestKeys))
                {
                    throw new ApiMissingParameterException("Missing parameter: $key.");
                }
            }
        }
    }

    /**
     * Return model parameters
     */
    public function getModelParameters(): array
    {
        $arrParameters = [];

        if($limit = $this->request->get('limit'))
        {
            $arrParameters['limit'] = $limit;
        }

        if($offset = $this->request->get('offset'))
        {
            $arrParameters['offset'] = $offset;
        }

        return $arrParameters;
    }

    /**
     * Return the image path
     *
     * @param $varSingleSrc
     * @param $imgSize
     *
     * @return boolean
     */
    protected function getImagePath($varSingleSrc, $imgSize)
    {
        if ($varSingleSrc)
        {
            if (!($varSingleSrc instanceof FilesModel) && Validator::isUuid($varSingleSrc))
            {
                $objModel = FilesModel::findByUuid($varSingleSrc);
            }
            else
            {
                $objModel = $varSingleSrc;
            }

            $container = System::getContainer();
            $strRoot = $container->getParameter('kernel.project_dir');

            if ($objModel !== null && is_file($strRoot . '/' . $objModel->path))
            {
                return Image::getPath(
                    $container->get('contao.image.image_factory')->create($strRoot . '/' . $objModel->path, $imgSize)->getUrl($strRoot)
                );
            }
        }

        return false;
    }
}
