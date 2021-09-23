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

/**
 * Loads and writes filter information
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class FilesHelper
{
    public static function fileExt($file, $uc=true, $last=true)
    {
        $parts = explode('.',$file);
        if(count($parts)>2) {
            if($last) {
                $ext = $parts[count($parts)-1];
            } else $ext = array($parts[count($parts)-2],$parts[count($parts)-1]);
        } else $ext = $parts[count($parts)-1];

        if(\is_array($ext)) {
            foreach($ext as &$x) {
                if($uc) $x = strtoupper($x); else $x = strtolower($x);
            }
        } else {
            if($uc) $ext = strtoupper($ext); else $ext = strtolower($ext);
        }
        return $ext;
    }

    public static function fileBaseName($file)
    {
        $parts = explode('/',$file);
        $file = $parts[count($parts)-1];
        $parts = explode('.',$file);
        unset($parts[count($parts)-1]);
        return implode('.',$parts);
    }

    public static function filename($file)
    {
        $parts = explode('/',$file);
        $file = $parts[count($parts)-1];
        return $file;
    }

    public static function fileDirPath($path)
    {
        $pos = strrpos($path,'/');
        return substr($path,0,$pos+1);
    }

    public static function scandirByExt($path, $extensions=array(), $recursive=false)
    {
        $result = array();

        if(is_dir(TL_ROOT . '/' . $path)) {
            $files = scandir(TL_ROOT . '/' . $path);

            foreach($files as $file) {
                if (\in_array($file, array('.', '..'))) {
                    continue;
                }

                if(!is_dir(TL_ROOT . '/' . $path . '/' . $file)) {
                    $ext = explode('.', $file);
                    $ext = strtolower($ext[count($ext) - 1]);
                    if (\in_array($ext, $extensions, false)) $result[] = $path . '/' . $file;
                } elseif ($recursive) {
                    $result = array_merge($result, self::scandirByExt($path . '/' . $file, $extensions, $recursive));
                }
            }
        }

        return $result;
    }

    public static function fileModTime($path)
    {
        if(file_exists(TL_ROOT . '/'. $path)) {
            return filemtime(TL_ROOT . '/'. $path);
        } else return false;
    }

    public static function fileSize($path)
    {
        if(file_exists(TL_ROOT . '/'. $path)) {
            return filesize(TL_ROOT . '/' . $path);
        } else return false;
    }

    public static function fileSizeFormated($path)
    {
        $size = static::fileSize($path);

        if ($size < 1024) {
            return $size . ' Bytes';
        } elseif ($size <= 1048576) {
            return round($size / 1024) . ' KB';
        } else {
            return round($size / 1048576) . ' MB';
        }
    }

    public static function isWritable($path)
    {
        return is_writable(TL_ROOT.'/'.$path);
    }

    public static function isValidMd5($hash)
    {
        return preg_match('/^[a-f0-9]{32}$/', $hash);
    }
}
