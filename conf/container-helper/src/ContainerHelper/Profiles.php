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
     * @var array
     */
    protected $profiles = [];

    /**
     * @var string
     */
    protected $currentProfile = '';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $debugkey = '';

    /**
     * @var string
     */
    protected $adminkey = '';

    /**
     * Constructor
     *
     * @param array $config
     * @return void
     */
    public function __construct(array $config)
    {
        $defaultConfigs = $config['profile']['defaults'];
        foreach ($config['profile']['config'] as $profile => $c) {
            $m = [];
            if (preg_match('/^(?P<type>[a-z]+).*/', $profile, $m)) {
                $this->profiles[$profile] = array_merge($defaultConfigs[$m['type']], $c);
            }
        }
        $this->currentProfile = $config['profile']['profile'];
        $this->config = $this->profiles[$this->currentProfile];
    }

    /**
     * Get debug key
     *
     * @return string
     */
    public function getDebugKey(): string
    {
        return $this->debugkey;
    }

    /**
     * Get admin key
     *
     * @return string
     */
    public function getAdminKey(): string
    {
        return $this->adminkey;
    }

    /**
     * Refresh keys
     *
     * @return void
     */
    public function refresh()
    {
        $this->debugkey = $this->config['debugkey'];
        if ($this->debugkey === '@random') {
            $this->debugkey = random_string();
        }
        $this->adminkey = $this->config['adminkey'];
        if ($this->config['adminkey'] === '@random') {
            $this->adminkey = random_string();
        }
    }

    /**
     * Get profile
     *
     * @return string
     */
    public function getProfile(): string
    {
        return $this->currentProfile;
    }

    /**
     * Get available profiles
     *
     * @return array
     */
    public function getAvailableProfiles(): array
    {
        return array_keys($this->profiles);
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Set profile
     *
     * @param string $profile
     * @return void
     */
    public function setProfile(string $profile)
    {
        $this->currentProfile = $profile;
        $this->config = $this->profiles[$this->currentProfile];
    }
}
