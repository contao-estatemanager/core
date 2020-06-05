<?php

namespace ContaoEstateManager;

use Contao\ModuleModel;
use ContaoEstateManager\EstateManager\Controller\AbstractEstateManagerController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * EstateManager read api controller.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class EstateManagerRead extends AbstractEstateManagerController
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
            case 'estates':
                // validate parameters
                $validParameters = array('filter', 'filterMode', 'groups', 'fields', 'dataType', 'template', 'jumpTo', 'mode', 'pageId', 'moduleId');
                $this->currParam = $this->getParameters($this->method, $validParameters);

                // prepare model
                $arrColumns = array();
                $arrValues  = array();
                $arrOptions = $this->getModelParameters($this->method);

                if($this->currParam['filter'] && $this->currParam['filterMode'])
                {
                    $objSessionFilter = FilterSession::getInstance($this->currParam['pageId']);

                    $objModule = null;

                    if ($this->currParam['moduleId'])
                    {
                        $objModule = ModuleModel::findByPk($this->currParam['moduleId']);
                    }

                    list($arrColumns, $arrValues, $options) = $objSessionFilter->getParameter($this->currParam['groups'], $this->currParam['filterMode'], true, $objModule);

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

                if($id)
                {
                    $arrColumns[] = 'id=?';
                    $arrValues[]  = $id;
                }

                $objRealEstates = RealEstateModel::findBy($arrColumns, $arrValues, $arrOptions);

                if($objRealEstates === null){
                    return new JsonResponse($this->error(
                        'No results found',
                        self::STATUS_ZERO_RESULTS
                    ));
                }

                switch($this->currParam['dataType'])
                {
                    case 'geojson':
                        // To import valid geojson, the result must be returned without nesting.
                        $data = $this->parseGeoJsonArray($objRealEstates);
                        break;
                    default:
                        $data['results'] = $this->parseRealEstates($objRealEstates);
                }

                break;

            case 'contactpersons':

                // validate parameters
                $validParameters = array('fields', 'imgSize');
                $this->currParam = $this->getParameters($this->method, $validParameters);

                // prepare model
                $arrColumns = array();
                $arrValues  = array();
                $arrOptions = array();

                if($id)
                {
                    $arrColumns[] = 'id=?';
                    $arrValues[]  = $id;
                }

                $objContacts = ContactPersonModel::findBy($arrColumns, $arrValues, $arrOptions);

                if($objContacts === null){
                    return new JsonResponse($this->error(
                        'No results found',
                        self::STATUS_ZERO_RESULTS
                    ));
                }

                if(is_array($this->currParam['fields']))
                {
                    while($objContacts->next())
                    {
                        foreach ($this->currParam['fields'] as $field)
                        {
                            switch($field)
                            {
                                case 'image':
                                case 'singleSRC':
                                    $imageSize = array();

                                    if(is_array($this->currParam['imgSize']))
                                    {
                                        $imageSize = $this->currParam['imgSize'];
                                    }

                                    $data['results'][$objContacts->id][ $field ] = $this->getImagePath($objContacts->{$field}, $imageSize);
                                    break;
                                default:
                                    $data['results'][$objContacts->id][ $field ] = $objContacts->{$field};
                            }

                        }
                    }
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
    private function parseRealEstates($objRealEstates){
        $collection = array();

        while($objRealEstates->next())
        {
            $collection[] = $this->parseRealEstateCollection($objRealEstates->current());
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
    private function parseRealEstateCollection($objRealEstate)
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
                        $mainImage = $realEstate->getMainImageUuid();
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

        // add template
        if($this->currParam['template'])
        {
            $objTemplate = new \FrontendTemplate($this->currParam['template']);
            $objTemplate->setData($collection['fields']);
            $collection['template'] = $objTemplate->parse();
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
    private function parseGeoJsonArray($objRealEstates)
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

        return $arrGeoJson;
    }
}
