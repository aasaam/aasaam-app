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

class NginxStatus extends AbstractLog
{
    public function __construct()
    {
        $data = $this->request('http://127.0.0.1/__status');
        if (!$data) {
            file_put_contents('/tmpfs/logs/nginx.status.log', json_encode([
                'time' => gmdate('Y-m-d\TH:i:s'),
                'success' => false,
            ]) . "\n", FILE_APPEND);
            return;
        }
        $m = [];
        $result = [];
        if (preg_match('/Active : (?P<nginxActive>[0-9]+)/', $data, $m)) {
            $result['active'] = (int)$m['nginxActive'];
            $result['success'] = true;
        }
        $n = [];
        if (preg_match('/(?P<nginxAccepts>[0-9]+) (?P<nginxHandled>[0-9]+) (?P<nginxRequests>[0-9]+)/s', $data, $n)) {
            $result['accepts'] = (int)$n['nginxAccepts'];
            $result['handled'] = (int)$n['nginxHandled'];
            $result['requests'] = (int)$n['nginxRequests'];
        }
        $o = [];
        if (preg_match('/Reading: (?P<nginxReading>[0-9]+)/', $data, $o)) {
            $result['reading'] = (int)$o['nginxReading'];
        }
        $p = [];
        if (preg_match('/Writing: (?P<nginxWriting>[0-9]+)/', $data, $p)) {
            $result['writing'] = (int)$p['nginxWriting'];
        }
        $q = [];
        if (preg_match('/Waiting: (?P<nginxWaiting>[0-9]+)/', $data, $q)) {
            $result['waiting'] = (int)$q['nginxWaiting'];
        }
        file_put_contents('/tmpfs/logs/nginx.status.log', json_encode(array_merge([
            'time' => gmdate('Y-m-d\TH:i:s'),
        ], $result)) . "\n", FILE_APPEND);
        return;
    }
}
