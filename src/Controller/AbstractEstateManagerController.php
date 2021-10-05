<?php

namespace ContaoEstateManager\EstateManager\Controller;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\FilesModel;
use Contao\Frontend;
use Contao\Image;
use Contao\System;
use Contao\Validator;

/**
 * Abstract EstateManager Controller.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class AbstractEstateManagerController extends Frontend
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
     * @var ContaoFramework
     */
    private $framework;

    /**
     * Constructor
     */
    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
        $this->framework->initialize();

        // Load the user object before calling the parent constructor
        $this->import('FrontendUser', 'User');

        parent::__construct();
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
            if (\in_array($key, $arrValidParam))
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

            if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
            {
                return Image::getPath(System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/' . $objModel->path, $imgSize)->getUrl(TL_ROOT));
            }
        }

        return false;
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
