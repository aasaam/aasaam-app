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

use ContainerHelper\Applier;
use ContainerHelper\Command\AbstractCommand;
use ContainerHelper\Config;
use ContainerHelper\Profiles;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputOption;

class ConfigCommand extends AbstractCommand
{
    /**
     * @var \ContainerHelper\Profiles
     */
    protected $profiles;

    /**
     * @var array
     */
    protected $config = [];

    protected function configure()
    {
        $this->config = Config::get();
        $this->profiles = new Profiles($this->config);
        
        $this
            ->setName('config')
            ->addOption('profile', 'p', InputOption::VALUE_REQUIRED, 'Container profile', null)
            ->addOption('restart', 'r', InputOption::VALUE_OPTIONAL, 'Restart services after change profile?', 'no')
            ->setDescription('Config the container by profile.')
            ->setHelp(vsprintf("List of profiles are: `<info>%s</info>` and for restart method use `<info>%s</info>`", [
                implode('</info>`, `<info>', $this->profiles->getAvailableProfiles()),
                implode('`, `', ['yes', 'no', '1', '0', 'on', 'off'])
            ]));
    }

    protected function checkArguments()
    {
        if (empty($this->input->getOption('profile'))) {
            $this->output->writeln(vsprintf('<error>Profile must be set from these: %s</error>', [
                implode(', ', $this->profiles->getAvailableProfiles()),
            ]));
            exit(128);
        }
        
        if (!in_array($this->input->getOption('profile'), $this->profiles->getAvailableProfiles())) {
            $this->output->writeln(vsprintf('<error>Profile `%s` not found</error>', [
                $this->input->getOption('profile'),
            ]));
            exit(128);
        }
        
        if ($this->input->getOption('restart') !== null) {
            if (!in_array($this->input->getOption('restart'), ['yes', 'no', '1', '0', 'on', 'off'])) {
                $this->output->writeln('<error>Restart parameters must be `yes` or `no`.</error>');
                exit(128);
            }
            $this->input->setOption('restart', filter_var($this->input->getOption('restart'), FILTER_VALIDATE_BOOLEAN));
        }
    }

    protected function executeMe(): void
    {
        $this->profiles->setProfile($this->input->getOption('profile'));
        $this->profiles->refresh();

        $this->config['profile']['profile'] = $this->profiles->getProfile();

        $applier = new Applier($this->profiles);
        $this->output->writeln(vsprintf('Profile now is <info>%s</info>', [
            $this->profiles->getProfile(),
        ]));
        $debugkey = $this->profiles->getDebugKey();
        if ($debugkey) {
            $this->output->writeln(vsprintf('Your new debug key is <info>%s</info>', [
                $debugkey,
            ]));
        }

        $adminkey = $this->profiles->getAdminKey();
        if ($adminkey) {
            $this->output->writeln(vsprintf('Your new admin key is <info>%s</info>', [
                $adminkey,
            ]));
            $this->config['adminkey'] = $adminkey;
        }
        
        $this->config['adminkey'] = $adminkey;
        $this->config['debugkey'] = $debugkey;
        Config::overwrite($this->config);

        if ($this->input->getOption('restart')) {
            $steps = [
                'Stop nginx...' => 'service nginx stop',
                'Stop php fpm...' => 'service php7.2-fpm stop',
                'Restart jobber...' => 'service jobber restart',
                'Stop immortal...' => 'immortalctl halt "*"',
            ];

            if (getenv('CONTAINER_ENV') !== 'dev') {
                $steps['Fluentbit start...']
                    = 'immortal -c /app/etc/immortal/fluent-bit.yml';
                $steps['Container helper logcollector start...']
                    = 'immortal -c /app/etc/immortal/container-helper-log.yml';
            }

            $steps['Start php fpm...']
            = 'service php7.2-fpm start';
            $steps['Start nginx...']
                = 'service nginx start';

            ProgressBar::setFormatDefinition('custom', '<fg=cyan>%message%</> (%current%/%max%) ');
            $progressBar = new ProgressBar($this->output, count($steps));
            $progressBar->setFormat('custom');
            $progressBar->setMessage('Start...');
            $progressBar->start();
            foreach ($steps as $message => $command) {
                $progressBar->setMessage($message);
                $progressBar->advance();
                shell_exec($command);
            }
            $progressBar->finish();
            $this->output->writeln('<info>Done</info>');
        }
    }
}
