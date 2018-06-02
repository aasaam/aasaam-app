<?php declare(strict_types=1);
/**
 * AASAAM App container configure
 *
 * @category  Application
 * @package   ContainerHelper
 * @author    Muhammad Hussein Fattahizadeh <m@mhf.ir>
 * @copyright 2018 Muhammad Hussein Fattahizadeh <m@mhf.ir>
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      https://github.com/AASAAM/aasaam-app/
 */

namespace ContainerHelper\Log;

use ContainerHelper\Log\AbstractLog;

class PhpErrorLog extends AbstractLog
{
    const ERRORLOGPATH = '/tmpfs/logs/php.error.log';
    const ERRORLOGPATH_TMP = '/tmpfs/logs/php.error.log.tmp';
    const ERRORLOGPATH_OUTPUT = '/tmpfs/logs/php.error.parsed.log';

    public function __construct()
    {
        if (!file_exists(self::ERRORLOGPATH)) {
            return;
        }

        copy(self::ERRORLOGPATH, self::ERRORLOGPATH_TMP);
        file_put_contents(self::ERRORLOGPATH, '');

        $id = 0;
        $patterns = [
            'firstLine' => '/^\[(?P<date>[^\]]{22,})\](?P<log>.*)$/',
            'otherLine' => '/^(?P<log>.*)$/',
        ];

        $logs = [];
        foreach ($this->readFileLine(self::ERRORLOGPATH_TMP) as $line) {
            $matches = [];
            if (preg_match($patterns['firstLine'], $line, $matches)) {
                $id++;
                $logs[$id]['time'] = gmdate('Y-m-d\TH:i:s', strtotime($matches['date']));
                $logs[$id]['log'][] = trim($matches['log']);
            } elseif (preg_match($patterns['otherLine'], $line, $matches)) {
                $logs[$id]['log'][] = trim($matches['log']);
            }
        }

        if (empty($logs)) {
            return;
        }

        $file = fopen(self::ERRORLOGPATH_OUTPUT, "a");
        foreach ($logs as $log) {
            $log['log'] = implode("\n", $log['log']);
            $log['hash'] = sha1($log['log']);
            fwrite($file, json_encode($log) . "\n");
        }
        fclose($file);
        unlink(self::ERRORLOGPATH_TMP);
        return;
    }


    /**
     * Read file line
     *
     * @param string $path
     * @return string
     */
    private function readFileLine(string $path)
    {
        $handle = fopen($path, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                yield trim($line);
            }
            fclose($handle);
        }
    }
}
