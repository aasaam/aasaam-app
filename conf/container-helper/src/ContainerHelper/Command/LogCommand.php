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
use ContainerHelper\Log\NetworkConnection;
use ContainerHelper\Log\NginxStatus;
use ContainerHelper\Log\PhpErrorLog;
use ContainerHelper\Log\PhpFpmSlow;
use ContainerHelper\Log\PhpFpmStatus;
use ContainerHelper\Log\PingStatus;
use ContainerHelper\Profiles;
use React\EventLoop\Factory as EventLoopFactory;
use Symfony\Component\Console\Output\OutputInterface;

class LogCommand extends AbstractCommand
{
    /**
     * @var \ContainerHelper\Profiles
     */
    protected $profiles;

    protected function configure()
    {
        $this
            ->setName('log');
    }

    protected function executeMe(): void
    {
        $config = Config::get();

        if ($config['networklog']) {
            new PingStatus();
        }


        $loop = EventLoopFactory::create();

        $NginxStatus = function () {
            new NginxStatus();
            $this->output->writeln(
                'Nginx status',
                OutputInterface::VERBOSITY_VERY_VERBOSE
            );
        };

        $PingStatus = function () {
            new PingStatus();
            $this->output->writeln(
                'Ping status',
                OutputInterface::VERBOSITY_VERY_VERBOSE
            );
        };

        $NetworkConnection = function () {
            new NetworkConnection();
            $this->output->writeln(
                'Ping status',
                OutputInterface::VERBOSITY_VERY_VERBOSE
            );
        };

        $PhpErrorLog = function () {
            new PhpErrorLog();
            $this->output->writeln(
                'Php fpm status',
                OutputInterface::VERBOSITY_VERY_VERBOSE
            );
        };

        $PhpFpmStatus = function () {
            new PhpFpmStatus();
            $this->output->writeln(
                'Php fpm status',
                OutputInterface::VERBOSITY_VERY_VERBOSE
            );
        };

        $PhpFpmSlow = function () {
            new PhpFpmSlow();
            $this->output->writeln(
                'Php fpm status',
                OutputInterface::VERBOSITY_VERY_VERBOSE
            );
        };


        $loop->addPeriodicTimer(29, $NginxStatus);
        $loop->addPeriodicTimer(59, $PhpFpmStatus);
        $loop->addPeriodicTimer(101, $PhpErrorLog);
        $loop->addPeriodicTimer(127, $PhpFpmSlow);

        if ($config['networklog']) {
            $loop->addPeriodicTimer(41, $PingStatus);
            $loop->addPeriodicTimer(47, $NetworkConnection);
        }

        $loop->run();
    }
}
