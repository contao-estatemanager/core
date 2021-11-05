<?php

namespace ContaoEstateManager\EstateManager\Controller\Api;

use ContaoEstateManager\ContactPersonModel;
use ContaoEstateManager\EstateManager\Exception\ApiParameterException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for real estates.
 *
 * @Route(defaults={"_scope" = "frontend"})
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ApiProviderController extends AbstractApiController
{
    /**
     * Return a collection of contact persons or a single person
     *
     * Parameter:
     * - fields     The contact fields to be queried and returned.
     * - imgSize    Image size to use.
     *
     * @Route("/api/estatemanager/v1/contactpersons/{id}", name="estatemanager_contactperson")
     */
    public function contactpersons(?int $id=null)
    {
        $arrColumns[] = 'published=?';
        $arrValues[]  = 1;
        $arrOptions = $this->getModelParameters();

        if($id)
        {
            $arrColumns[] = 'id=?';
            $arrValues[]  = $id;
        }

        $objContacts = ContactPersonModel::findBy($arrColumns, $arrValues, $arrOptions);
        $arrFields = $this->request->get('fields') ?? ['id'];

        if(!\is_array($arrFields))
        {
            throw new ApiParameterException('The `fields` parameter must be an array.');
        }

        if($objContacts !== null)
        {
            $imageSize = $this->request->get('imgSize') ?: null;

            $data = [];
            $arrContacts = [];

            foreach($objContacts as $objContact)
            {
                foreach ($arrFields as $field)
                {
                    switch($field)
                    {
                        case 'image':
                        case 'singleSRC':
                            $value = $this->getImagePath($objContact->{$field}, $imageSize);
                            break;

                        default:
                            $value = $objContact->{$field};
                    }

                    $arrContacts[ $field ] = $value;
                }

                $data[] = $arrContacts;
            }
        }

        return $this->createResponse($data ?? null);
    }
}
