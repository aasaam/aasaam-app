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

namespace ContainerHelper;

class NetworkEndpoints
{
    const LIST = [
        'https://public-dns.info/nameserver/ir.json',
    ];

    const SERVERLIST_PATH = '/tmpfs/container-helper/publicdns_all.json';

    protected static $servers = [];

    protected static $defaultServers = [
        'US' => [
            '8.8.8.8' => 'Mountain View',
            '4.2.2.4' => 'Dallas',
            '208.67.222.222' => 'San Francisco',
        ],
        'DE' => [
            '213.133.98.98' => 'Freising',
        ],
        'NL' => [
            '62.212.64.121' => 'Amsterdam',
        ],
        'CA' => [
            '128.189.4.1' => 'Vancouver',
        ],
        'IR' => [
            '185.147.178.12' => 'Tehran',
        ],
    ];

    /**
     * Servers reload
     *
     * @return void
     */
    public static function reload()
    {
        self::$servers = self::$defaultServers;
        file_put_contents(self::SERVERLIST_PATH, json_encode(self::$servers, JSON_PRETTY_PRINT));
        foreach (self::LIST as $jsonUrl) {
            $list = self::request($jsonUrl);
            if ($list) {
                $serverList = json_decode($list, true);
                foreach ($serverList as $server) {
                    if (isset($server['reliability']) && $server['reliability'] === 1 && !empty($server['city'])) {
                        self::addServer($server);
                    }
                }
            }
        }
        file_put_contents(self::SERVERLIST_PATH, json_encode(self::$servers, JSON_PRETTY_PRINT));
    }

    /**
     * Has init
     *
     * @return boolean
     */
    public static function hasInit(): bool
    {
        shell_exec('find /tmpfs/container-helper -type f -name "publicdns_*" -mtime +8 -delete');
        return file_exists(self::SERVERLIST_PATH);
    }

    /**
     * Get targets
     *
     * @param integer $max
     * @param array $countries
     * @param array $notCountries
     * @return array
     */
    public static function getTargets(int $max = 2, array $countries = [], array $notCountries = []): array
    {
        if (file_exists(self::SERVERLIST_PATH)) {
            $list = json_decode(file_get_contents(self::SERVERLIST_PATH), true);
            if (!empty($countries)) {
                $list = array_filter($list, function ($v, $k) use ($countries) {
                    if (in_array($k, $countries)) {
                        return true;
                    }
                    return false;
                }, ARRAY_FILTER_USE_BOTH);
            }
            if (!empty($notCountries)) {
                $list = array_filter($list, function ($v, $k) use ($notCountries) {
                    if (in_array($k, $notCountries)) {
                        return false;
                    }
                    return true;
                }, ARRAY_FILTER_USE_BOTH);
            }
            $result = [];
            foreach ($list as $country => $ipdata) {
                foreach ($ipdata as $ip => $city) {
                    $result[] = [
                        'country' => $country,
                        'city' => $city,
                        'ip' => $ip,
                    ];
                }
            }
            shuffle($result);
            return array_slice($result, 0, $max);
        }
        return [
            'country' => 'US',
            'city' => 'Dallas',
            'ip' => '4.2.2.4',
        ];
    }

    /**
     * Add server
     *
     * @param array $server
     * @return void
     */
    protected static function addServer(array $server)
    {
        if (self::isPingable($server['ip'])) {
            self::$servers[$server['country_id']][$server['ip']] = $server['city'];
        }
    }

    /**
     * Is pingable
     *
     * @param string $ip
     * @return boolean
     */
    protected static function isPingable(string $ip)
    {
        $data = trim(shell_exec('ping -c 1 -w 2 ' . $ip));
        if (strpos($data, ' 0% packet loss') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Request url
     *
     * @param string $url
     * @return mixed
     */
    protected static function request(string $url)
    {
        shell_exec('find /tmpfs/container-helper -type f -name "publicdns_*" -mtime +8 -delete');
        $cacheFile = '/tmpfs/container-helper/publicdns_' . crc32($url . gmdate('YmW')) . '.bin';
        if (file_exists($cacheFile)) {
            return file_get_contents($cacheFile);
        }
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_USERAGENT, BOT_USERAGENT);
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($response !== false && $httpcode === 200) {
                file_put_contents($cacheFile, $response);
                return $response;
            }
        } catch (Throwable $e) {
            return false;
        }

        return false;
    }
}
