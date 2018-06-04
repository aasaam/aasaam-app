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
use ContainerHelper\Config;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends AbstractCommand
{
    /**
     * @var \ContainerHelper\Profiles
     */
    protected $profiles;

    protected function configure()
    {
        $this
            ->setName('status');
    }

    protected function executeMe(): void
    {
        $config = Config::get();
        $this->output->writeln(vsprintf('Profile is <info>%s</info>', [
            $config['profile']['profile'],
        ]));
        $debugkey = $config['debugkey'];
        if (!empty($debugkey)) {
            $this->output->writeln(vsprintf('Your debug key is <info>%s</info>', [
                $debugkey,
            ]));
        }
        $adminkey = $config['adminkey'];
        if (!empty($adminkey)) {
            $this->output->writeln(vsprintf('Your admin key is <info>%s</info>', [
                $adminkey,
            ]));
        }
    }
}
