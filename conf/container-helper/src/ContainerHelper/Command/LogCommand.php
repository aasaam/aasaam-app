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

use Amp\Delayed;
use Amp\Loop;
use ContainerHelper\Log\ConnectivityStatus;
use ContainerHelper\Log\NginxStatus;
use ContainerHelper\Log\PhpFpmSlow;
use ContainerHelper\Log\PhpFpmStatus;
use ContainerHelper\Profiles;
use function Amp\asyncCall;
use React\Promise\Deferred;

class LogCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('log')
            ->setDescription('Log events to file')
            ->setHelp('Check statuses and log to files for process fluentbit');
    }

    protected function executeMe(): void
    {
        $profiles = new Profiles();
        while (true) {
            if (!$profiles->isSwoole()) {
                asyncCall(function () {
                    new PhpFpmStatus();
                    yield new Delayed(30 * TIME_RATIO);
                });
                asyncCall(function () {
                    new PhpFpmSlow();
                    yield new Delayed(120 * TIME_RATIO);
                });
            }
            asyncCall(function () {
                new NginxStatus();
                yield new Delayed(20 * TIME_RATIO);
            });
            asyncCall(function () {
                new ConnectivityStatus();
                yield new Delayed(180 * TIME_RATIO);
            });
            Loop::run();
            sleep(1);
        }
    }
}
