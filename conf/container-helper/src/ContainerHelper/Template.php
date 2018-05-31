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

use ContainerHelper\Profiles;
use League\Plates\Engine;

class Template
{
    /**
     * @var \ContainerHelper\Profiles
     */
    protected $profiles;

    /**
     * Constructor
     *
     * @param Profiles $profiles
     */
    public function __construct(Profiles $profiles)
    {
        $this->profiles = $profiles;
        $this->templates = new Engine('templates', 'phtml');
        $this->templates->addData(['date' => gmdate('r') . "\n"]);
        $this->apply();
    }

    /**
     * @return void
     */
    public function apply(): void
    {
        $configs = $this->profiles->getConfig();
        file_put_contents('/etc/php/7.2/fpm/pool.d/www.conf', $this->fpmConfig());
        file_put_contents('/app/etc/nginx/conf.d/host-config.conf', $this->nginxConfig());
        file_put_contents('/etc/php/7.2/mods-available/aasaamphpconfig.ini', $this->phpConfig());

        shell_exec('phpenmod aasaamphpconfig');

        if ($configs['phpxdebug']) {
            shell_exec('phpenmod xdebug');
        } else {
            shell_exec('phpdismod xdebug');
        }

        if ($configs['phpspx']) {
            $content = file_get_contents('/etc/php/7.2/mods-available/spx.ini');
            $replacement = 'spx.http_key="' . RANDOM_KEY . '"';
            $result = preg_replace('/spx\.http_key="[^"]+"/', $replacement, $content);
            file_put_contents('/etc/php/7.2/mods-available/spx.ini', $result);
            shell_exec('phpenmod spx');
        } else {
            shell_exec('phpdismod spx');
        }
    }

    /**
     * @return string
     */
    private function fpmConfig(): string
    {
        return $this->templates->render('www.conf', $this->profiles->getConfig());
    }

    /**
     * @return string
     */
    private function nginxConfig(): string
    {
        return $this->templates->render('host-config.conf', $this->profiles->getConfig());
    }

    /**
     * @return string
     */
    private function phpConfig(): string
    {
        return $this->templates->render('aasaamphpconfig.ini', $this->profiles->getConfig());
    }
}
