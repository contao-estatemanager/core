<?php

namespace ContaoEstateManager;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * EstateManager read api controller.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class EstateManagerRead extends EstateManagerSDK
{
    /**
     * Method
     * @var string
     */
    private $method = self::METHOD_GET;

    /**
     * Current Parameter
     * @var string
     */
    private $currParam = null;

    /**
     * Run the controller
     *
     * @param String $module  Plural name of EstateManager module
     * @param int    $id      Id
     *
     * @return JsonResponse
     */
    public function run($module, $id)
    {
        $data = array(
            'results' => null,
            'status' => self::STATUS_ZERO_RESULTS
        );

        switch ($module)
        {
            case 'estate':

                if(!$id)
                {
                    $data = $this->error(
                        'Module estate expected parameter id',
                        self::ERR_WRONG_PARAM
                    );

                    break;
                }

                // ToDo: Module estate stuff

                break;
            case 'estates':

                // validate parameters
                $validParameters = array('filter', 'filterMode', 'groups', 'fields', 'dataType', 'template', 'jumpTo', 'mode');
                $this->currParam = $this->getParameters($this->method, $validParameters);

                // prepare model
                $arrColumns = array();
                $arrValues  = array();
                $arrOptions = $this->getModelParameters($this->method);

                if($this->currParam['filter'] && $this->currParam['filterMode'])
                {
                    $objSessionFilter = FilterSession::getInstance();

                    list($arrColumns, $arrValues, $options) = $objSessionFilter->getParameter($this->currParam['groups'], $this->currParam['filterMode']);

                    $arrOptions = array_merge($arrOptions, $options);
                }

                // HOOK: Modify parameters for module estates
                if (isset($GLOBALS['TL_HOOKS']['readEstatesControllerParameter']) && \is_array($GLOBALS['TL_HOOKS']['readEstatesControllerParameter']))
                {
                    foreach ($GLOBALS['TL_HOOKS']['readEstatesControllerParameter'] as $callback)
                    {
                        $this->import($callback[0]);
                        $this->{$callback[0]}->{$callback[1]}($arrColumns, $arrValues, $arrOptions, $this->currParam, $this);
                    }
                }

                $objRealEstates = $this->fetchItems($arrColumns, $arrValues, $arrOptions);

                switch($this->currParam['dataType'])
                {
                    case 'geojson':
                        // To import valid geojson, the result must be returned without nesting.
                        $data = $this->parseGeoJsonArray($objRealEstates);
                        break;
                    default:
                        $data['results'] = $this->parseRealEstatesFields($objRealEstates);
                }

                break;
        }

        // set new status if there no data
        if($data['results'] !== null && count($data['results']))
        {
            $data['status'] = self::STATUS_SUCCESS;
        }

        return new JsonResponse($data);
    }

    /**
     * Parse and return an array of real estates with given fields
     *
     * @param $objRealEstates
     * @param $fields
     *
     * @return array
     */
    private function parseRealEstatesFields($objRealEstates){
        $collection = array();

        while($objRealEstates->next())
        {
            $collection[] = $this->parseRealEstateFields($objRealEstates);
        }

        return $collection;
    }

    /**
     * Parse and return an array of an real estate with given fields
     *
     * @param $objRealEstate
     *
     * @return array
     */
    private function parseRealEstateFields($objRealEstate)
    {
        // create RealEstate instance
        $realEstate = new RealEstate($objRealEstate, null);

        // set id, dateAdded, and tstamp as dateChanged by default
        $collection = array(
            'id'          => $objRealEstate->id,
            'dateAdded'   => $objRealEstate->dateAdded,
            'dateChanged' => $objRealEstate->tstamp
        );

        if(is_array($this->currParam['fields']))
        {
            // create fields array
            $collection['fields'] = array();

            // extract special fields
            foreach ($this->currParam['fields'] as $field)
            {
                $value = null;

                switch($field)
                {
                    case 'mainDetails':    $value = $realEstate->getMainDetails(); break;
                    case 'mainAttributes': $value = $realEstate->getMainAttributes(); break;
                    case 'mainArea':       $value = $realEstate->getMainArea(); break;
                    case 'mainPrice':      $value = $realEstate->getMainPrice(); break;
                    case 'marketingToken': $value = $realEstate->getMarketingToken(); break;
                    case 'exposeUrl':
                        if($this->currParam['jumpTo'])
                        {
                            $value = $realEstate->generateExposeUrl($this->currParam['jumpTo']);
                        }

                        break;
                    case 'mainImage':
                        $fallback = false;
                        $mainImage = $realEstate->getMainImage();
                        $defaultImage = \Config::get('defaultImage');

                        if($mainImage)
                        {
                            $objFileModel = \FilesModel::findByUuid($mainImage);

                            if ($objFileModel !== null && is_file(TL_ROOT . '/' . $objFileModel->path))
                            {
                                $value = $objFileModel->path;
                            }
                            else $fallback = true;
                        }else $fallback = true;

                        if($fallback && $defaultImage)
                        {
                            $objFileModel = \FilesModel::findByUuid($defaultImage);

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

                if($value)
                {
                    $collection['fields'][$field] = $value;
                }
            }
        }

        return $collection;
    }

    /**
     * Create and return a GeoJSON format array
     *
     * @param $objRealEstates
     * @param $fields
     * @param bool $template
     *
     * @return array
     */
    private function parseGeoJsonArray($objRealEstates)
    {
        $latCoordinates = array();
        $lngCoordinates = array();

        $arrGeoJson = array(
            'type'     => 'FeatureCollection',
            'features' => array()
        );

        while($objRealEstates->next())
        {
            if($objRealEstates->breitengrad && $objRealEstates->laengengrad)
            {
                $template = false;
                $parsedFields = $this->parseRealEstateFields($objRealEstates, $this->currParam['fields']);

                if($this->currParam['template'])
                {
                    $objTemplate = new \FrontendTemplate($this->currParam['template']);
                    $objTemplate->setData($parsedFields['fields']);
                    $template = $objTemplate->parse();
                }

                $arrRealEstate = array(
                    'type'     => 'Feature',
                    'geometry' => array(
                        'type'        => 'Point',
                        'coordinates' => array(
                            $objRealEstates->laengengrad,
                            $objRealEstates->breitengrad
                        )
                    ),
                    'properties'  => array_merge(
                        $parsedFields,
                        ['popup' => $template]
                    )
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

        return $arrGeoJson;
    }
}
