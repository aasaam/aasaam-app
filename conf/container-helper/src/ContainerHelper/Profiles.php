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

class Profiles
{
    /**
     * @var string
     */
    protected $profile = 'prod-logs';

    /**
     * @var array
     */
    protected $config = [
        'nginxaccesslog' => false,
        'phpxdebug' => false,
        'phpspx' => false,
        'phpfpmslowlog' => false,
        'phpfpmaccesslog' => false,
        'opcacheperformance' => false,
        'fastcgicache' => true,
    ];

    /**
     * @var array
     */
    protected $profileConfig = [
        'dev' => [
            'nginxaccesslog' => true,
            'phpxdebug' => true,
            'phpspx' => true,
            'phpfpmslowlog' => true,
            'phpfpmaccesslog' => true,
            'opcacheperformance' => false,
            'fastcgicache' => false,
        ],
        'dev-cache' => [
            'nginxaccesslog' => true,
            'phpxdebug' => true,
            'phpspx' => true,
            'phpfpmslowlog' => true,
            'phpfpmaccesslog' => true,
            'opcacheperformance' => false,
            'fastcgicache' => true,
        ],
        'prod-logs' => [
            'nginxaccesslog' => true,
            'phpxdebug' => false,
            'phpspx' => false,
            'phpfpmslowlog' => true,
            'phpfpmaccesslog' => true,
            'opcacheperformance' => true,
            'fastcgicache' => true,
        ],
        'prod-debug' => [
            'nginxaccesslog' => true,
            'phpxdebug' => true,
            'phpspx' => true,
            'phpfpmslowlog' => true,
            'phpfpmaccesslog' => true,
            'opcacheperformance' => false,
            'fastcgicache' => true,
        ],
        'prod' => [
            'nginxaccesslog' => false,
            'phpxdebug' => false,
            'phpspx' => false,
            'phpfpmslowlog' => false,
            'phpfpmaccesslog' => false,
            'opcacheperformance' => true,
            'fastcgicache' => true,
        ],
    ];


    const CONFIG_FILE = '/tmpfs/container-config.json';

    /**
     * Constructor
     */
    public function __construct()
    {
        $defaults = [
            'profile' => $this->profile,
            'config' => $this->config,
        ];
        if (file_exists(self::CONFIG_FILE)) {
            $defaults = json_decode(file_get_contents(self::CONFIG_FILE), true);
        }
        $this->profile = $defaults['profile'];
        $this->config = $defaults['config'];
    }

    /**
     * Set profile
     *
     * @param string $profile
     * @return void
     */
    public function setProfile(string $profile): void
    {
        if (isset($this->profileConfig[$profile])) {
            $this->profile = $profile;
            $this->config = $this->profileConfig[$profile];
        }
    }

    /**
     * Set config
     *
     * @param string $name
     * @param boolean $state
     * @return void
     */
    public function setConfig(string $name, bool $state): void
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $state;
        }
    }

    /**
     * Get profile
     *
     * @return string
     */
    public function getProfile(): string
    {
        return $this->profile;
    }

    /**
     * Get Config
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $defaults = [
            'profile' => $this->profile,
            'config' => $this->config,
        ];
        file_put_contents(self::CONFIG_FILE, json_encode($defaults, JSON_PRETTY_PRINT));
    }
}
