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
use Throwable;

class ConnectivityStatus extends AbstractLog
{
    protected $endpoints = [
        'https' => [
            'https://lib.arvancloud.com/ar/jquery/3.3.1/jquery.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/core.js',
            'https://www.asiatech.ir/robots.txt',
        ],
        'http' => [
            'http://it.php.net/robots.txt',
            'http://www.shatel.ir/robots.txt',
            'http://www.asiatech.ir/robots.txt',
        ],
        'ping' => [
            '4.2.2.4',
            '8.8.8.8',
            '208.67.222.222',
            '91.99.96.158',
        ],
    ];

    public function __construct()
    {
        try {
            $result = [];

            foreach ($this->endpoints['ping'] as $endpoint) {
                $result[] = $this->pingHost($endpoint);
            }

            foreach ($this->endpoints['https'] as $endpoint) {
                $data = $this->responseInfo($endpoint);
                $host = parse_url($endpoint, PHP_URL_HOST);
                if ($data) {
                    $result[] = [
                        'time' => gmdate('Y-m-d\TH:i:s'),
                        'mode' => 'https',
                        'success' => true,
                        'ip' => gethostbyname($host),
                        'host' => $host,
                        'response_time' => $data['total_time'],
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
            }
            foreach ($this->endpoints['http'] as $endpoint) {
                $data = $this->responseInfo($endpoint);
                $host = parse_url($endpoint, PHP_URL_HOST);
                if ($data) {
                    $result[] = [
                        'time' => gmdate('Y-m-d\TH:i:s'),
                        'mode' => 'http',
                        'success' => true,
                        'ip' => gethostbyname($host),
                        'host' => $host,
                        'response_time' => $data['total_time'],
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
        if (curl_exec($ch) !== false) {
            return curl_getinfo($ch);
        }
        return false;
    }

    /**
     * Response information
     *
     * @param string $host
     * @return array
     */
    protected function pingHost(string $host): array
    {
        $data = trim(shell_exec('ping -c 4 -w 10 ' . $host));
        $m = [];
        $result = [
            'time' => gmdate('Y-m-d\TH:i:s'),
            'mode' => 'ping',
            'host' => $host,
            'success' => false,
            'ip' => $host,
            'response_time' => -1,
        ];
        if (preg_match_all('/time=(?P<response_time>[0-9]+)/', $data, $m)) {
            $result['response_time'] =  array_sum($m['response_time']) / count($m['response_time']);
            if ($result['response_time'] < 500) {
                $result['success'] = true;
            }
            $n = [];
            if (preg_match('/(?<loss>)% packet loss/', $data, $n)) {
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
