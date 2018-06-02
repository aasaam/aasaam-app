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

namespace ContainerHelper\Command;

use ContainerHelper\Command\AbstractCommand;
use ContainerHelper\Profiles;
use Symfony\Component\Console\Input\InputArgument;

class RestartServices extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('restart-services')
            ->setDescription('Restart services for apply changes.')
            ->setHelp('Quick way to restart nginx, php-fpm, immportal and jobber for apply changes');
    }

    protected function executeMe(): void
    {
        $profiles = new Profiles();

        $commands = [
            'service nginx stop',
            'service php7.2-fpm stop',
            'service jobber restart',
            'immortalctl halt "*"',
        ];

        if (getenv('CONTAINER_ENV') !== 'dev') {
            $commands[] = 'immortal -c /app/etc/immortal/beanstalkd.yml';
            $commands[] = 'immortal -c /app/etc/immortal/container-helper-log.yml';
        }

        if (!$profiles->isSwoole()) {
            $commands[] = 'service php7.2-fpm start';
        }

        $commands[] = 'service nginx start';
        foreach ($commands as $c) {
            shell_exec($c);
        }
    }
}
