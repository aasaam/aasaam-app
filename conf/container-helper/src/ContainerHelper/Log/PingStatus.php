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

class PingStatus extends AbstractLog
{
    const CACHE_PATH = '/tmpfs/container-helper/pingstatuscache.json';
    const MAX_CHECKLIST = 2;

    /**
     * @var string
     */
    protected $logpath = '/tmpfs/logs/network.ping.status.log';

    /**
     * @var array
     */
    protected $servers = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->update();
        $this->start();
    }

    /**
     * Start
     *
     * @return void
     */
    protected function start()
    {
        $servers = $this->servers;
        shuffle($servers);
        $selectedServers = [
            'default' => [],
            'list' => [],
        ];

        foreach ($servers as $s) {
            if ($s['type'] === 'default' && count($selectedServers['default']) < self::MAX_CHECKLIST) {
                $selectedServers['default'][] = $s;
            }
            if ($s['type'] === 'list' && count($selectedServers['list']) <  self::MAX_CHECKLIST) {
                $selectedServers['list'][] = $s;
            }
        }

        foreach ($selectedServers as $l) {
            foreach ($l as $server) {
                $this->pingHost($server);
            }
        }
    }

    /**
     * Ping host
     *
     * @param array $server
     * @return void
     */
    protected function pingHost(array $server): void
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
            'packetloss' => 100,
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
                    $result['packetloss'] = 0;
                } else {
                    $result['packetloss'] = (int)$n['loss'];
                    $result['success'] = false;
                }
            }
        }
        $this->writeSuccess($result);
    }

    /**
     * Update
     *
     * @return void
     */
    protected function update()
    {
        if (file_exists(self::CACHE_PATH) && filemtime(self::CACHE_PATH) > (time() - 86400)) {
            $this->servers = json_decode(file_get_contents(self::CACHE_PATH), true);
            return;
        }
        $config = Config::get();
        foreach ($config['connectionstatus']['ping']['default'] as $country => $serverData) {
            foreach ($serverData as $ip => $city) {
                $this->servers[$ip] = [
                    'type' => 'default',
                    'ip' => $ip,
                    'country' => $country,
                    'city' => $city,
                ];
            }
        }
        foreach ($config['connectionstatus']['ping']['publicdnslist'] as $url) {
            $data = $this->request($url);
            if ($data) {
                $list = json_decode($data['response'], true);
                foreach ($list as $server) {
                    $this->addServer($server);
                }
            }
        }
        file_put_contents(self::CACHE_PATH, json_encode($this->servers));
    }

    /**
     * Add server
     *
     * @param array $server
     * @return void
     */
    protected function addServer(array $server)
    {
        if (!isset($server['reliability']) || empty($server['city']) || $server['reliability'] != 1) {
            return;
        }
        if (!$this->isPingable($server['ip'])) {
            return;
        }
        $this->servers[$server['ip']] = [
            'type' => 'list',
            'ip' => $server['ip'],
            'country' => $server['country_id'],
            'city' => $server['city'],
        ];
    }

    /**
     * Is pingable
     *
     * @param string $ip
     * @return boolean
     */
    protected static function isPingable(string $ip)
    {
        $data = trim(shell_exec('ping -c 1 -w 3 ' . $ip));
        if (strpos($data, ' 1 received') !== false) {
            return true;
        }
        return false;
    }
}
