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
use ContainerHelper\Config;

class NetworkConnection extends AbstractLog
{
    const MAX_CHECKLIST = 2;

    /**
     * @var string
     */
    protected $logpath = '/tmpfs/logs/network.http.status.log';

    /**
     * @var array
     */
    protected $servers = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->start();
    }

    /**
     * Start
     *
     * @return void
     */
    protected function start()
    {
        $config = Config::get();
        $urls = $config['connectionstatus']['testurls'];
        shuffle($urls);
        $urls = array_slice($urls, 0, self::MAX_CHECKLIST);
        foreach ($urls as $url) {
            $schema = parse_url($url, PHP_URL_SCHEME);
            $host = parse_url($url, PHP_URL_HOST);
            $ip = gethostbyname($host);

            if ($schema === 'https') {
                $httpsUrl = $url;
                $httpUrl = str_replace('https://', 'http://', $url);
            } elseif ($schema === 'http') {
                $httpUrl = $url;
                $httpsUrl = str_replace('http://', 'https://', $url);
            }

            $httpData = $this->request($httpUrl);
            if ($httpData) {
                $this->writeSuccess([
                    'time' => gmdate('Y-m-d\TH:i:s'),
                    'mode' => 'http',
                    'success' => true,
                    'ip' => $ip,
                    'host' => $host,
                    'response_time' => $httpData['info']['total_time'],
                ]);
            } else {
                $this->writeSuccess([
                    'time' => gmdate('Y-m-d\TH:i:s'),
                    'mode' => 'http',
                    'success' => false,
                    'ip' => $ip,
                    'host' => $host,
                ]);
            }

            $httpsData = $this->request($httpsUrl);
            if ($httpsData) {
                $this->writeSuccess([
                    'time' => gmdate('Y-m-d\TH:i:s'),
                    'mode' => 'https',
                    'success' => true,
                    'ip' => $ip,
                    'host' => $host,
                    'response_time' => $httpsData['info']['total_time'],
                ]);
            } else {
                $this->writeSuccess([
                    'time' => gmdate('Y-m-d\TH:i:s'),
                    'mode' => 'https',
                    'success' => false,
                    'ip' => $ip,
                    'host' => $host,
                ]);
            }
        }
    }
}
