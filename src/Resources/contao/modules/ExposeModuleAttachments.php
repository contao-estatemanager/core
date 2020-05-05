<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/core
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */


namespace ContaoEstateManager;

use Contao\BackendTemplate;
use Contao\Controller;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\Environment;
use Contao\File;
use Contao\FilesModel;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Patchwork\Utf8;

/**
 * Expose module "attachments".
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ExposeModuleAttachments extends ExposeModule
{
    /**
     * Files object
     * @var Collection|FilesModel
     */
    protected $objDocuments;

    /**
     * Link array
     * @var array
     */
    protected $arrLinks;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_attachments';

    /**
     * Do not display the module if there are no real estates
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['attachments'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=expose_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        switch($this->attachmentType)
        {
            case 'documents':
                $arrDocuments = StringUtil::deserialize($this->realEstate->documents);

                // Return if there are no files
                if (empty($arrDocuments) && !\is_array($arrDocuments))
                {
                    return '';
                }

                // Get the file entries from the database
                $this->objDocuments = FilesModel::findMultipleByUuids($arrDocuments);

                if ($this->objDocuments === null)
                {
                    return '';
                }

                $file = Input::get('file', true);

                // Send the file to the browser (see #4632 and #8375)
                if ($file != '' && (!isset($_GET['cid']) || Input::get('cid') == $this->id))
                {
                    while ($this->objDocuments->next())
                    {
                        if ($file == $this->objDocuments->path || \dirname($file) == $this->objDocuments->path)
                        {
                            Controller::sendFileToBrowser($file, (bool) !$this->forceDownload);
                        }
                    }

                    if (isset($_GET['cid']))
                    {
                        throw new PageNotFoundException('Invalid file name');
                    }

                    $this->objDocuments->reset();
                }
                break;
            case 'links':
                $this->arrLinks = StringUtil::deserialize($this->realEstate->links, true);

                // Return if there are no links
                if (empty($this->arrLinks) && !\is_array($this->arrLinks))
                {
                    return '';
                }

                break;
        }

        $strBuffer = parent::generate();

        return $this->isEmpty ? '' : $strBuffer;
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $arrCollection = array();

        switch($this->attachmentType)
        {
            case 'documents':
                $allowedExtensions = StringUtil::trimsplit(',', strtolower($this->allowedFileExtensions));

                $objFiles = $this->objDocuments;

                // Get all files
                while ($objFiles->next())
                {
                    // Continue if the files has been processed or does not exist
                    if (!file_exists(System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFiles->path))
                    {
                        continue;
                    }

                    $objFile = new File($objFiles->path);

                    if (!\in_array($objFile->extension, $allowedExtensions))
                    {
                        continue;
                    }


                    $objAttachment = new \stdClass();

                    $objAttachment->title = StringUtil::specialchars($objFile->filename);
                    $objAttachment->name = StringUtil::specialchars($objFile->basename);
                    $objAttachment->filesize = $this->getReadableSize($objFile->filesize);
                    $objAttachment->mime = $objFile->mime;
                    $objAttachment->extension = $objFile->extension;

                    $strHref = Environment::get('request');

                    // Remove an existing file parameter (see #5683)
                    if (isset($_GET['file']))
                    {
                        $strHref = preg_replace('/(&(amp;)?|\?)file=[^&]+/', '', $strHref);
                    }

                    if (isset($_GET['cid']))
                    {
                        $strHref = preg_replace('/(&(amp;)?|\?)cid=\d+/', '', $strHref);
                    }

                    $strHref .= (strpos($strHref, '?') !== false ? '&amp;' : '?') . 'file=' . System::urlEncode($objFiles->path) . '&amp;cid=' . $this->id;

                    $objAttachment->href = $strHref;

                    $arrCollection[] = $objAttachment;
                }

                break;
            case 'links':
                foreach ($this->arrLinks as $link){
                    $objAttachment = new \stdClass();
                    $objAttachment->href = $link;
                    $objAttachment->extension = 'link';

                    $arrCollection[] = $objAttachment;
                }

                break;
        }

        if(empty($arrCollection))
        {
            $this->isEmpty = true;
        }

        $this->Template->attachments = $arrCollection;
    }
}
