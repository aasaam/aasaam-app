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

class PhpFpmStatus extends AbstractLog
{
    /**
     * @var string
     */
    protected $logpath = '/tmpfs/logs/php.fpm.status.log';

    /**
     * Constructor
     */
    public function __construct()
    {
        $response = $this->request('http://127.0.0.1/__status/fpm?json');
        if (!$response) {
            $this->writeFaild();
            return;
        }
        $result = json_decode($response['response'], true);
        if (is_array($result)) {
            $this->writeSuccess($result);
        }
    }
}
