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

class PhpFpmSlow extends AbstractLog
{
    const SLOWLOGPATH = '/tmpfs/logs/php.fpm.slow.log';
    const SLOWLOGPATH_TMP = '/tmpfs/logs/php.fpm.slow.log.tmp';
    const SLOWLOGPATH_OUTPUT = '/tmpfs/logs/php.fpm.slow.parsed.log';

    public function __construct()
    {
        if (!file_exists(PhpFpmSlow::SLOWLOGPATH)) {
            return;
        }

        copy(PhpFpmSlow::SLOWLOGPATH, PhpFpmSlow::SLOWLOGPATH_TMP);
        file_put_contents(PhpFpmSlow::SLOWLOGPATH, '');

        $id = 0;
        $patterns = [
            'firstLine' => '/^\[(?P<date>[^\]]+)\].*pid\s[0-9]+$/',
            'methodLine' => '/^\[[^\]]+\]\s(?P<method>[^\s]+)\s(?P<file>[^\s]+)\:(?P<line>[0-9]+)$/',
            'otherLine' => '/^\[[^\]]+\]\s(?P<message>.*)$/',
        ];

        $logs = [];

        foreach ($this->readFileLine(PhpFpmSlow::SLOWLOGPATH_TMP) as $line) {
            $matches = [];
            if (preg_match($patterns['firstLine'], $line, $matches)) {
                $id++;
                $logs[$id]['time'] = gmdate('Y-m-d\TH:i:s', strtotime($matches['date']));
            } elseif (preg_match($patterns['methodLine'], $line, $matches)) {
                $logs[$id]['trace'][] = [
                    'method' => $matches['method'],
                    'file' => $matches['file'],
                    'line' => $matches['line'],
                ];
            } elseif (preg_match($patterns['otherLine'], $line, $matches)) {
                $logs[$id]['trace'][] = [
                    'message' => $matches['message'],
                ];
            }
        }

        if (empty($logs)) {
            return;
        }

        $file = fopen(PhpFpmSlow::SLOWLOGPATH_OUTPUT, "a");
        foreach ($logs as $log) {
            fwrite($file, json_encode($log) . "\n");
        }
        fclose($file);
        unlink(PhpFpmSlow::SLOWLOGPATH_TMP);
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
