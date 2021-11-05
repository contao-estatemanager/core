<?php

namespace ContaoEstateManager\EstateManager\Controller\Api;

use Contao\Config;
use Contao\FilesModel;
use Contao\FrontendTemplate;
use Contao\ModuleModel;
use ContaoEstateManager\EstateManager\Exception\ApiParameterException;
use ContaoEstateManager\RealEstate;
use ContaoEstateManager\RealEstateModel;
use ContaoEstateManager\RealEstateModulePreparation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for real estates.
 *
 * @Route(defaults={"_scope" = "frontend"})
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ApiRealEstateController extends AbstractApiController
{
    /**
     * Return a collection of properties or a single property
     *
     * Parameters:
     * - session       Defines whether a filtering from SessionManager should be applied. Requires `pageId`.
     * - filterMode    Defines the filter mode.
     * - groups        Defines the groups that will be used for filtering.
     *
     * - fields        The object fields to be queried and displayed.
     * - format        The output format (json, geojson). Default is json.
     *
     * - template      Returns a parsed template. Requires `moduleId` and format `geojson`.
     * - pageId
     * - moduleId
     *
     * - limit
     * - offset
     *
     * @Route("/api/estatemanager/v1/estates/{id}", name="estatemanager_estates")
     */
    public function estates(?int $id = null): Response
    {
        $arrColumns =
        $arrValues  = [];
        $arrOptions = $this->getModelParameters();

        // Apply module
        if ($intModuleId = $this->request->get('moduleId'))
        {
            $this->objModule = ModuleModel::findByPk($intModuleId);
        }

        // Apply filter
        if($this->request->get('session'))
        {
            // Apply filtering
            [$arrColumns, $arrValues, $options] = $this->applyFilter();

            // Merge options
            $arrOptions = array_merge($arrOptions, $options);
        }

        // Check if a specific property is called
        if($id)
        {
            $arrColumns[] = 'id=?';
            $arrValues[]  = $id;
        }

        // Get real estates (published only)
        $objRealEstates = RealEstateModel::findPublishedBy($arrColumns, $arrValues, $arrOptions);

        if($objRealEstates !== null)
        {
            switch($this->request->get('format'))
            {
                // Check for the special case geojson
                case 'geojson':
                    return $this->parseGeoJsonArray($objRealEstates);

                default:
                    $data = $this->parseRealEstates($objRealEstates);
            }
        }

        return $this->createResponse($data ?? null);
    }

    /**
     * Parse and return an array of real estates
     *
     * @param $objRealEstates
     *
     * @return array
     */
    private function parseRealEstates($objRealEstates): ?array
    {
        if(null === $objRealEstates)
        {
            return null;
        }

        $collection = array();

        foreach($objRealEstates as $objRealEstate)
        {
            $collection[] = $this->parseRealEstateCollection($objRealEstate);
        }

        return $collection;
    }

    /**
     * Parse and return an array of a real estate with given fields
     */
    private function parseRealEstateCollection(RealEstateModel $objRealEstate)
    {
        $collection = array(
            'id'          => $objRealEstate->id,
            'dateAdded'   => $objRealEstate->dateAdded,
            'dateChanged' => $objRealEstate->tstamp
        );

        if(null !== $this->objModule)
        {
            $realEstate = new RealEstateModulePreparation($objRealEstate, $this->objModule, null);
        }
        else
        {
            $realEstate = new RealEstate($objRealEstate, null);
        }

        if($arrFields = $this->request->get('fields'))
        {
            if(!\is_array($arrFields))
            {
                throw new ApiParameterException('The `fields` parameter must be an array.');
            }

            // Create fields array
            $collection['fields'] = [];

            // handle fields
            foreach ($arrFields as $field)
            {
                switch($field)
                {
                    case 'mainDetails':    $value = $realEstate->getMainDetails(); break;
                    case 'mainAttributes': $value = $realEstate->getMainAttributes(); break;
                    case 'mainArea':       $value = $realEstate->getMainArea(); break;
                    case 'mainPrice':      $value = $realEstate->getMainPrice(); break;
                    case 'marketingToken': $value = $realEstate->getMarketingToken(); break;
                    case 'exposeUrl':      $value = $realEstate->generateExposeUrl(); break;
                    case 'mainImage':
                        $fallback = false;
                        $mainImage = $realEstate->getMainImageUuid();
                        $defaultImage = Config::get('defaultImage');

                        if($mainImage)
                        {
                            $objFileModel = FilesModel::findByUuid($mainImage);

                            if ($objFileModel !== null && is_file(TL_ROOT . '/' . $objFileModel->path))
                            {
                                $value = $objFileModel->path;
                            }
                            else $fallback = true;
                        }else $fallback = true;

                        if($fallback && $defaultImage)
                        {
                            $objFileModel = FilesModel::findByUuid($defaultImage);

                            if ($objFileModel !== null && is_file(TL_ROOT . '/' . $objFileModel->path))
                            {
                                $value = $objFileModel->path;
                            }
                        }

                        break;
                    default:
                        if($realEstate->formatter->isFilled($field))
                        {
                            $value = $realEstate->formatter->getFormattedCollection($field);
                        }
                }

                if($value ?? false)
                {
                    $collection['fields'][$field] = $value;
                }
            }
        }

        // add template
        if($strTemplate = $this->request->get('template'))
        {
            $objTemplate = new FrontendTemplate($strTemplate);

            if(null !== $this->objModule)
            {
                $objTemplate->setData($this->objModule->row());
            }

            $objTemplate->realEstate = $realEstate;
            $collection['template'] = $objTemplate->parse();
        }

        return $collection;
    }

    /**
     * Create and return a GeoJSON format array
     */
    private function parseGeoJsonArray($objRealEstates): JsonResponse
    {
        $latCoordinates = array();
        $lngCoordinates = array();

        $arrGeoJson = array(
            'type'     => 'FeatureCollection',
            'features' => array()
        );

        if($objRealEstates !== null)
        {
            while($objRealEstates->next())
            {
                if($objRealEstates->breitengrad && $objRealEstates->laengengrad)
                {
                    $parsedFields = $this->parseRealEstateCollection($objRealEstates->current());

                    $arrRealEstate = array(
                        'type'     => 'Feature',
                        'geometry' => array(
                            'type'        => 'Point',
                            'coordinates' => array(
                                $objRealEstates->laengengrad,
                                $objRealEstates->breitengrad
                            )
                        ),
                        'properties'  => $parsedFields
                    );

                    $arrGeoJson['features'][] = $arrRealEstate;

                    $latCoordinates[] = $objRealEstates->breitengrad;
                    $lngCoordinates[] = $objRealEstates->laengengrad;
                }
            }

            $arrGeoJson['bbox'] = array(
                [min($lngCoordinates),min($latCoordinates)],
                [max($lngCoordinates),max($latCoordinates)]
            );
        }

        return new JsonResponse($arrGeoJson);
    }
}
