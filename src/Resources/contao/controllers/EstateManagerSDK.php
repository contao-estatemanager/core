<?php

namespace ContaoEstateManager;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * EstateManager SDK.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class EstateManagerSDK extends \Frontend
{
    /** Method Contants */
    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';

    /** Error Contants */
    const ERR_WRONG_PARAM = 'ERR_WRONG_PARAM';

    /** Status Contants */
    const STATUS_ZERO_RESULTS = 'ZERO_RESULTS';
    const STATUS_SUCCESS = 'OK';

    /**
     * SDK Constructor
     */
    public function __construct()
    {
        // Load the user object before calling the parent constructor
        $this->import('FrontendUser', 'User');
        parent::__construct();

        // Check whether a user is logged in
        \define('BE_USER_LOGGED_IN', $this->getLoginStatus('BE_USER_AUTH'));
        \define('FE_USER_LOGGED_IN', $this->getLoginStatus('FE_USER_AUTH'));
    }

    /**
     * Return parameters by method
     *
     * @param $method
     * @param array $arrValidParam Array of valid parameters
     * @param array $arrDefaultParam Optional array of default parameters
     *
     * @return array
     */
    public function getParameters($method, $arrValidParam, $arrDefaultParam=array())
    {
        $arrMethod = array();
        $param = $arrDefaultParam;

        switch($method){
            case self::METHOD_GET:  $arrMethod = $_GET; break;
            case self::METHOD_POST: $arrMethod = $_POST; break;
        }

        foreach ($arrMethod as $key => $value)
        {
            if (in_array($key, $arrValidParam))
            {
                $param[$key] = $value;
            }
        }

        return $param;
    }

    /**
     * Return model parameters by method
     *
     * @param $method
     *
     * @return array
     */
    public function getModelParameters($method){
        return $this->getParameters($method, array('limit', 'offset'));
    }

    /**
     * Count the total matching items
     *
     * @param $arrColumns
     * @param $arrValues
     * @param $arrOptions
     *
     * @return integer
     */
    public function countItems($arrColumns, $arrValues, $arrOptions)
    {
        return RealEstateModel::countBy($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * Fetch the matching items
     *
     * @param $arrColumns
     * @param $arrValues
     * @param $arrOptions
     *
     * @return \Model\Collection|RealEstateModel|null
     */
    public function fetchItems($arrColumns, $arrValues, $arrOptions)
    {
        return RealEstateModel::findBy($arrColumns, $arrValues, $arrOptions);
    }

    /**
     * ToDo: Create Exception-Class for throwable errors
     *
     * Create and return an error array
     *
     * @param $msg
     * @param $status
     *
     * @return array
     */
    public function error($msg, $status){
        return array(
            'status' => $status,
            'error_message' => $msg
        );
    }
}
