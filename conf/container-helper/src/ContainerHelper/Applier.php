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

use League\Plates\Engine;

class Applier
{
    /**
     * @var \ContainerHelper\Profiles
     */
    protected $profiles;

    /**
     * @var \League\Plates\Engine
     */
    protected $templates;

    /**
     * Constructor
     *
     * @param \ContainerHelper\Profiles $profiles
     */
    public function __construct(Profiles $profiles)
    {
        $this->profiles = $profiles;
        $this->templates = new Engine(ROOT_PATH . '/templates', 'phtml');

        $this->templates->addData(['date' => gmdate('r') . "\n"]);
        $this->templates->addData(['env' => $_SERVER]);
        $this->templates->addData(['config' => $this->profiles->getConfig()]);
        $this->templates->addData(['devmode' => $this->profiles->isDevMode()]);
        $this->templates->addData(['profile' => $this->profiles->getProfile()]);
        $this->templates->addData(['debugkey' => $this->profiles->getDebugKey()]);
        $this->templates->addData(['adminkey' => $this->profiles->getAdminKey()]);
        $this->apply();
    }

    /**
     * @return void
     */
    public function apply(): void
    {
        $configs = $this->profiles->getConfig();

        file_put_contents(
            '/etc/php/7.2/fpm/pool.d/www.conf',
            $this->templates->render('www.conf')
        );

        file_put_contents(
            '/app/etc/nginx/conf.d/host-config.conf',
            $this->templates->render('host-config.conf')
        );

        file_put_contents(
            '/etc/php/7.2/mods-available/aasaam-container-helper.ini',
            $this->templates->render('aasaam-container-helper.ini')
        );

        shell_exec('phpenmod aasaam-container-helper');

        $adminAuthFile = '/app/var/config/admin.htpasswd';
        shell_exec('rm -rf ' . $adminAuthFile);
        $adminkey = $this->profiles->getAdminKey();
        if (!empty($adminkey) && strlen($adminkey) > 3) {
            shell_exec(vsprintf('htpasswd -b -c %s %s %s 2>&1 > /dev/null', [
                $adminAuthFile,
                $adminkey,
                $adminkey,
            ]));
        }

        $debugAuthFile = '/app/var/config/debug.htpasswd';
        shell_exec('rm -rf ' . $debugAuthFile);
        $debugkey = $this->profiles->getDebugKey();
        if (!empty($debugkey) && strlen($debugkey) > 3) {
            shell_exec(vsprintf('htpasswd -b -c %s %s %s 2>&1 > /dev/null', [
                $debugAuthFile,
                $debugkey,
                $debugkey,
            ]));
        }

        if ($configs['phpxdebug']) {
            if (!empty($debugkey)) {
                $content = file_get_contents('/etc/php/7.2/mods-available/xdebug.ini');
                $replacement = 'xdebug.profiler_enable_trigger_value="' . $debugkey . '"';
                $result = preg_replace('/xdebug\.profiler_enable_trigger_value="[^"]+"/', $replacement, $content);
                file_put_contents('/etc/php/7.2/mods-available/xdebug.ini', $result);
            }
            shell_exec('phpenmod xdebug');
        } else {
            shell_exec('phpdismod xdebug');
        }

        if ($configs['phpspx']) {
            if (!empty($debugkey)) {
                $content = file_get_contents('/etc/php/7.2/mods-available/spx.ini');
                $replacement = 'spx.http_key="' . $debugkey . '"';
                $result = preg_replace('/spx\.http_key="[^"]+"/', $replacement, $content);
                file_put_contents('/etc/php/7.2/mods-available/spx.ini', $result);
            }
            shell_exec('phpenmod spx');
        } else {
            shell_exec('phpdismod spx');
        }
    }
}
