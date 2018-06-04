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

use Throwable;

class Config
{
    const CONFIG_PATH = '/app/var/config/container-helper.yml';

    /**
     * @var array
     */
    protected static $config = [];

    /**
     * Init configuration
     *
     * @return void
     */
    public static function init()
    {
        if (!file_exists(self::CONFIG_PATH)) {
            $data = yaml_parse(file_get_contents(ROOT_PATH . '/container-helper.yml'));
            file_put_contents(self::CONFIG_PATH, yaml_emit($data));
        }
        try {
            self::$config = yaml_parse_file(self::CONFIG_PATH);
        } catch (Throwable $e) {
            echo $e->getMessage() . "\n";
            exit(1);
        }
    }

    /**
     * Get
     *
     * @param string $key
     * @throws Exception
     * @return mixed
     */
    public static function get(string $key = '')
    {
        if (empty($key)) {
            return self::$config;
        }

        if (!isset(self::$config[$key])) {
            throw new Exception('Config not found');
        }

        return self::$config[$key];
    }

    /**
     * Overwrite
     *
     * @param array $config
     * @return void
     */
    public static function overwrite(array $config)
    {
        self::$config = $config;
        file_put_contents(self::CONFIG_PATH, yaml_emit(self::$config));
    }
}
