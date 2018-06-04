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

use Throwable;

abstract class AbstractLog
{
    /**
     * Request url
     *
     * @param string $url
     * @return mixed
     */
    protected function request(string $url)
    {
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, BOT_USERAGENT);
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($response !== false && $httpcode >= 200 && $httpcode < 400) {
                return [
                    'response' => $response,
                    'info' => curl_getinfo($ch),
                ];
            }
        } catch (Throwable $e) {
            return false;
        }

        return false;
    }

    /**
     * Read file line
     *
     * @param string $path
     * @return string
     */
    protected function readFileLine(string $path)
    {
        $handle = fopen($path, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                yield trim($line);
            }
            fclose($handle);
        }
    }

    /**
     * Write faild
     *
     * @return void
     */
    protected function writeFaild(): void
    {
        file_put_contents($this->logpath, json_encode([
            'time' => gmdate('Y-m-d\TH:i:s'),
            'success' => false,
        ]) . "\n", FILE_APPEND);
    }

    /**
     * Write success
     *
     * @param array $result
     * @return void
     */
    protected function writeSuccess(array $result): void
    {
        file_put_contents($this->logpath, json_encode(array_merge([
            'time' => gmdate('Y-m-d\TH:i:s'),
            'success' => true,
        ], $result)) . "\n", FILE_APPEND);
    }
}
