<?php

namespace Oveleon\ContaoImmoManagerBundle;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * ImmoManager read api controller.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ImmoManagerRead extends ImmoManagerSDK
{
    /**
     * Method
     * @var string
     */
    private $method = self::METHOD_GET;

    /**
     * Filter Instance
     * @var RealEstateFilter
     */
    private $filter;

    /**
     * Filter Mode
     * @var string
     */
    private $filterMode;

    /**
     * Initialize the object
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Run the controller
     *
     * @param String $module  Plural name of ImmoManager module
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
                $validParameters = array('filter', 'fields', 'dataType');
                $param = $this->getParameters($this->method, $validParameters);

                // prepare model
                $arrColumns = null;
                $arrValues  = null;
                $arrOptions = $this->getModelParameters($this->method);

                if($param['filter'])
                {
                    // check if all parameters passed for using filter
                    if(!is_array($param['filter']) || !$param['filter']['pageId'] || !$param['filter']['mode'])
                    {
                        $data = $this->error(
                            'Parameter filter expected parameters pageId and mode',
                            self::ERR_WRONG_PARAM
                        );

                        break;
                    }

                    $this->setFilter($param['filter']['pageId'], $param['filter']['mode']);

                    list($arrColumns, $arrValues) = $this->filter->getParameter($this->filterMode);
                }

                $objRealEstates = $this->fetchItems($arrColumns, $arrValues, $arrOptions);

                switch($param['dataType'])
                {
                    case 'geojson':
                        $data['results'] = $this->parseGeoJsonArray($objRealEstates, $param['fields']);
                        break;
                    default:
                        $data['results'] = $this->parseRealEstatesFields($objRealEstates, $param['fields']);
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
    private function parseRealEstatesFields($objRealEstates, $fields){
        $collection = array();

        while($objRealEstates->next())
        {
            $collection[] = $this->parseRealEstateFields($objRealEstates, $fields);
        }

        return $collection;
    }

    /**
     * Parse and return an array of an real estate with given fields
     *
     * @param $objRealEstate
     * @param $fields
     *
     * @return array
     */
    private function parseRealEstateFields($objRealEstate, $fields)
    {
        // create RealEstate instance
        $realEstate = new RealEstate($objRealEstate, null);

        // set id, dateAdded, and tstamp as dateChanged by default
        $collection = array(
            'id'          => $objRealEstate->id,
            'dateAdded'   => $objRealEstate->dateAdded,
            'dateChanged' => $objRealEstate->tstamp
        );

        if(is_array($fields))
        {
            // create fields array
            $collection['fields'] = array();

            // extract special fields
            foreach ($fields as $field)
            {
                $value = null;

                // ToDo: Add custom fields like statusToken, mainAttributes,...
                switch($field)
                {
                    case 'mainDetails':    $value = $realEstate->getMainDetails(); break;
                    case 'mainAttributes': $value = $realEstate->getMainAttributes(); break;
                    case 'mainArea':       $value = $realEstate->getMainArea(); break;
                    case 'mainPrice':      $value = $realEstate->getMainPrice(); break;
                    case 'marketingToken': $value = $realEstate->getMarketingToken(); break;
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
     *
     * @return array
     */
    private function parseGeoJsonArray($objRealEstates, $fields)
    {
        $latCoordinates = array();
        $lngCoordinates = array();

        $arrGeoJson = array(
            'type'       => 'FeatureCollection',
            'features'   => array()
        );

        while($objRealEstates->next())
        {
            if($objRealEstates->breitengrad && $objRealEstates->laengengrad)
            {
                $arrRealEstate = array(
                    'type'     => 'Feature',
                    'geometry' => array(
                        'type'        => 'Point',
                        'coordinates' => array(
                            $objRealEstates->laengengrad,
                            $objRealEstates->breitengrad
                        )
                    ),
                    'properties'  => $this->parseRealEstateFields($objRealEstates, $fields)
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

    /**
     * Set filter instance
     *
     * @param $pageId
     * @param $filterMode
     */
    private function setFilter($pageId, $filterMode)
    {
        $this->filter = RealEstateFilter::getInstance($pageId);
        $this->filterMode = $filterMode;
    }
}