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
     * @var string
     */
    protected $spxKey = 'dev';

    /**
     * @var bool
     */
    protected $isSwoole = false;

    /**
     * @var array
     */
    protected $config = [
        'nginxaccesslog' => true,
        'phpxdebug' => false,
        'phpspx' => false,
        'phpfpmslowlog' => true,
        'phpfpmaccesslog' => true,
        'opcacheperformance' => true,
        'fastcgicache' => true,
        'proxycache' => true,
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
            'proxycache' => false,
        ],
        'dev-cache' => [
            'nginxaccesslog' => true,
            'phpxdebug' => true,
            'phpspx' => true,
            'phpfpmslowlog' => true,
            'phpfpmaccesslog' => true,
            'opcacheperformance' => false,
            'fastcgicache' => true,
            'proxycache' => true,
        ],
        'prod-logs' => [
            'nginxaccesslog' => true,
            'phpxdebug' => false,
            'phpspx' => false,
            'phpfpmslowlog' => true,
            'phpfpmaccesslog' => true,
            'opcacheperformance' => true,
            'fastcgicache' => true,
            'proxycache' => true,
        ],
        'prod-debug' => [
            'nginxaccesslog' => true,
            'phpxdebug' => true,
            'phpspx' => true,
            'phpfpmslowlog' => true,
            'phpfpmaccesslog' => true,
            'opcacheperformance' => false,
            'fastcgicache' => true,
            'proxycache' => true,
        ],
        'prod' => [
            'nginxaccesslog' => false,
            'phpxdebug' => false,
            'phpspx' => false,
            'phpfpmslowlog' => false,
            'phpfpmaccesslog' => false,
            'opcacheperformance' => true,
            'fastcgicache' => true,
            'proxycache' => true,
        ],
    ];


    const CONFIG_FILE = '/tmpfs/container-helper/config.json';

    /**
     * Constructor
     */
    public function __construct()
    {
        $defaults = [
            'spxKey' => $this->spxKey,
            'isSwoole' => $this->isSwoole,
            'profile' => $this->profile,
            'config' => $this->config,
        ];
        if (file_exists(self::CONFIG_FILE)) {
            $defaults = json_decode(file_get_contents(self::CONFIG_FILE), true);
        }
        $this->profile = $defaults['profile'];
        $this->config = $defaults['config'];
        $this->isSwoole = $defaults['isSwoole'];
    }

    /**
     * Change spx key
     *
     * @return void
     */
    public function changeSpxKey(): void
    {
        if (getenv('CONTAINER_ENV') !== 'dev') {
            $this->spxKey = random_string();
        } else {
            $this->spxKey = 'dev';
        }
    }

    /**
     * Get spx key
     *
     * @return string
     */
    public function getSpxKey(): string
    {
        return $this->spxKey;
    }

    /**
     * Apply
     *
     * @return void
     */
    public function apply(): void
    {
        $this->setProfile($this->profile);
        if ($this->isSwoole) {
            $this->config['phpxdebug'] = false;
            $this->config['phpspx'] = false;
            $this->config['phpfpmslowlog'] = false;
            $this->config['phpfpmaccesslog'] = false;
            $this->config['opcacheperformance'] = false;
            $this->config['fastcgicache'] = false;
        }
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
     * Set profile
     *
     * @param bool $isSwoole
     * @return void
     */
    public function setSwoole(bool $isSwoole): void
    {
        $this->isSwoole = $isSwoole;
    }

    /**
     * Is swoole
     *
     * @return boolean
     */
    public function isSwoole(): bool
    {
        return $this->isSwoole;
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
     * Get config file
     *
     * @return array
     */
    public function getConfigFile(): array
    {
        return [
            'spxKey' => $this->spxKey,
            'profile' => $this->profile,
            'config' => $this->config,
            'isSwoole' => $this->isSwoole,
        ];
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $defaults = [
            'spxKey' => $this->spxKey,
            'profile' => $this->profile,
            'config' => $this->config,
            'isSwoole' => $this->isSwoole,
        ];
        file_put_contents(self::CONFIG_FILE, json_encode($defaults, JSON_PRETTY_PRINT));
    }
}
