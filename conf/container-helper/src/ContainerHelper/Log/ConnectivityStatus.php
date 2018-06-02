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
use ContainerHelper\NetworkEndpoints;
use Throwable;

class ConnectivityStatus extends AbstractLog
{
    protected $httpsUrls = [
        'https://lib.arvancloud.com/ar/jquery/3.3.1/jquery.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/core.js',
        'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js',
        'https://irancell.ir/robots.txt',
        'https://www.asiatech.ir/robots.txt',
        'https://www.shatel.ir/robots.txt',
    ];

    public function __construct()
    {
        try {
            $result = [];

            $iranPing = NetworkEndpoints::getTargets(3, ['IR'], []);
            $worldPing = NetworkEndpoints::getTargets(3, [], ['IR']);

            foreach ($iranPing as $server) {
                $result[] = $this->pingHost($server);
            }

            foreach ($worldPing as $server) {
                $result[] = $this->pingHost($server);
            }

            foreach ($this->httpsUrls as $httpsUrl) {
                $host = parse_url($httpsUrl, PHP_URL_HOST);

                $httpsData = $this->responseInfo($httpsUrl);
                if ($httpsData) {
                    $result[] = [
                        'time' => gmdate('Y-m-d\TH:i:s'),
                        'mode' => 'https',
                        'success' => true,
                        'ip' => gethostbyname($host),
                        'host' => $host,
                        'response_time' => $httpsData['total_time'],
                    ];
                } else {
                    $result[] = [
                        'time' => gmdate('Y-m-d\TH:i:s'),
                        'mode' => 'https',
                        'success' => false,
                        'ip' => gethostbyname($host),
                        'host' => $host,
                    ];
                }

                $httpUrl = str_replace('https://', 'http://', $httpsUrl);
                $httpData = $this->responseInfo($httpUrl);
                if ($httpData) {
                    $result[] = [
                        'time' => gmdate('Y-m-d\TH:i:s'),
                        'mode' => 'http',
                        'success' => true,
                        'ip' => gethostbyname($host),
                        'host' => $host,
                        'response_time' => $httpData['total_time'],
                    ];
                } else {
                    $result[] = [
                        'time' => gmdate('Y-m-d\TH:i:s'),
                        'mode' => 'http',
                        'success' => false,
                        'ip' => gethostbyname($host),
                        'host' => $host,
                    ];
                }
            }
            foreach ($result as $row) {
                file_put_contents('/tmpfs/logs/network.status.log', json_encode($row) . "\n", FILE_APPEND);
            }
            return true;
        } catch (Throwable $e) {
            return false;
        }
        return false;
    }

    /**
     * Response information
     *
     * @param string $url
     * @return mixed
     */
    protected function responseInfo(string $url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, BOT_USERAGENT);
        if (curl_exec($ch) !== false) {
            return curl_getinfo($ch);
        }
        return false;
    }

    /**
     * Response information
     *
     * @param array $server
     * @return array
     */
    protected function pingHost(array $server): array
    {
        $data = trim(shell_exec('ping -c 4 -w 10 ' . $server['ip']));
        $m = [];
        $result = [
            'time' => gmdate('Y-m-d\TH:i:s'),
            'mode' => 'ping',
            'host' => $server['ip'],
            'success' => false,
            'ip' => $server['ip'],
            'response_time' => -1,
            'country' => $server['country'],
            'city' => $server['city'],
        ];
        if (preg_match_all('/time=(?P<response_time>[0-9]+)/', $data, $m)) {
            $result['response_time'] =  array_sum($m['response_time']) / count($m['response_time']);
            if ($result['response_time'] > -1 && $result['response_time'] < 500) {
                $result['success'] = true;
            }
            $n = [];
            if (preg_match('/ (?P<loss>[0-9]+)% packet loss/', $data, $n)) {
                if ($result['success'] === true && $n['loss'] === '0') {
                    $result['success'] = true;
                } else {
                    $result['success'] = false;
                }
            }
        }
        return $result;
    }
}
