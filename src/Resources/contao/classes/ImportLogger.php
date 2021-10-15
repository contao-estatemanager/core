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

use Contao\Config;
use Contao\File;

/**
 * Provide methods to log entries while importing.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ImportLogger
{
    public const LOG_DEV = 'dev';
    public const LOG_PROD = 'prod';

    public const LEVEL_ERROR = 0;
    public const LEVEL_WARN = 1;
    public const LEVEL_INFO = 2;

    private object $log;

    /**
     * Add log entry
     *
     * @throws \Exception
     */
    public function add(string $msg, array $context = null, int $level = self::LEVEL_INFO, string $logMode = self::LOG_DEV): void
    {
        if($logMode === self::LOG_DEV && !$this->isDev())
        {
            return;
        }

        $log = new \stdClass();
        $log->message = $msg;
        $log->context = $context;
        $log->level = $level;
        $log->time = time();

        $this->log = $log;

        $this->save();
    }

    /**
     * Add error log
     */
    public function error(string $msg, array $context = null, string $logMode = self::LOG_PROD): void
    {
        $e = new \Exception();

        $context[] = $e->getTrace()[1] ?? '';

        $this->add($msg, $context, self::LEVEL_ERROR, $logMode);
    }

    /**
     * Add warn log
     */
    public function warn(string $msg, array $context = null, string $logMode = self::LOG_PROD): void
    {
        $this->add($msg, $context, self::LEVEL_WARN, $logMode);
    }

    /**
     * Add info log
     */
    public function info(string $msg, array $context = null, string $logMode = self::LOG_DEV): void
    {
        $this->add($msg, $context, self::LEVEL_INFO, $logMode);
    }

    /**
     * Save logs
     *
     * @throws \Exception
     */
    private function save(): void
    {
        $filePath = 'system/logs/' . $this->getFilename();
        $objFile = new File($filePath);

        // Get current log as string
        $strLog = $this->toString();

        if($objFile->exists())
        {
            $objFile->append($strLog);
        }
        else
        {
            $objFile->write($strLog . "\n");
        }

        $objFile->close();
    }

    /**
     * Return the current log entry as a string
     */
    private function toString(): string
    {
        $format = '[%s] %s: %s %s';
        $context = '';

        if($this->log->context)
        {
            $context = json_encode($this->log->context);
        }

        return vsprintf($format, [
            date('c', $this->log->time),
            $this->levelToString($this->log->level),
            $this->log->message,
            $context
        ]);
    }

    /**
     * Return the given level as string
     */
    private function levelToString(int $level): string
    {
        switch ($level)
        {
            case self::LEVEL_ERROR: return 'ERROR';
            case self::LEVEL_WARN: return 'WARNING';
            default: return 'INFO';
        }
    }

    /**
     * Return current filename
     */
    private function getFilename(): string
    {
        return 'cem-' . ($this->isDev() ? self::LOG_DEV : self::LOG_PROD) . '-' . date("Y-m-d") . '.log';
    }

    /**
     * Check if dev mode is active
     */
    private function isDev(): bool
    {
        return Config::get('debugMode');
    }
}
