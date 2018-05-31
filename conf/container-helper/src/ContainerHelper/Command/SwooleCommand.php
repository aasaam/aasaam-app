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
use ContainerHelper\Template;
use Symfony\Component\Console\Input\InputArgument;

class SwooleCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('swoole')
            ->addArgument('enable', InputArgument::REQUIRED)
            ->setDescription('Configure the container is swoole base app.')
            ->setHelp('Quick way to configure the nginx, php for swoole app');
    }

    protected function executeMe(): void
    {
        define('RANDOM_KEY', substr(preg_replace('/[^a-z0-9]/i', '', base64_encode(hash('sha1', microtime(true) . uniqid('', true)))), 1, 12));
        $profiles = new Profiles();
        $profiles->setSwoole((bool)$this->input->getArgument('enable'));
        $profiles->apply();
        $swooleMode = $profiles->isSwoole() ? 'active' : 'disable';
        $this->output->writeln(vsprintf('Profile now is <info>%s</info> and swoole mode is <comment>%s</comment>', [
            $profiles->getProfile(),
            $swooleMode,
        ]));
        if ($profiles->getConfig()['phpspx']) {
            $this->output->writeln(vsprintf('SPX http key now is <info>%s</info>', [
                RANDOM_KEY,
            ]));
        }
        $this->output->writeln(vsprintf("Your configuration is now <info>%s</info>", [
            json_encode($profiles->getConfigFile(), JSON_PRETTY_PRINT),
        ]));
        new Template($profiles);
    }
}
