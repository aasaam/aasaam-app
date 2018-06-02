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

class PhpFpmStatus extends AbstractLog
{
    public function __construct()
    {
        $data = $this->request('http://127.0.0.1/__status/fpm?json');
        if ($data) {
            $data = json_decode($data, true);
            if (is_array($data)) {
                file_put_contents('/tmpfs/logs/php.fpm.status.log', json_encode(array_merge([
                    'time' => gmdate('Y-m-d\TH:i:s'),
                    'success' => true,
                ], $data)) . "\n", FILE_APPEND);
                return;
            }
        }
        file_put_contents('/tmpfs/logs/php.fpm.status.log', json_encode([
            'time' => gmdate('Y-m-d\TH:i:s'),
            'success' => false,
        ]) . "\n", FILE_APPEND);
        return false;
    }
}
