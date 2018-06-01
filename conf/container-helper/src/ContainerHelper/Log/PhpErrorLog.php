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

        $m = [];
        $file = fopen(self::ERRORLOGPATH_OUTPUT, "a");
        preg_match_all('/\[(?P<date>[^\]]{22,})\](?P<mode>[^:]+):(?P<message>[^\[]+)/m', file_get_contents(self::ERRORLOGPATH_TMP), $m);
        foreach ($m['date'] as $key => $date) {
            $time = gmdate('Y-m-d\TH:i:s', strtotime(trim($date)));
            $mode = trim($m['mode'][$key]);
            $message = trim($m['message'][$key]);
            fwrite($file, json_encode([
                'time' => $time,
                'mode' => $mode,
                'message' => $message,
            ]) . "\n");    
        }
        fclose($file);
        unlink(self::ERRORLOGPATH_TMP);
        return;
    }
}
