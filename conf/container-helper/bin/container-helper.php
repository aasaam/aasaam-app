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

if (getenv('DEBUG')) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    define('TIME_RATIO', 10);
} else {
    define('TIME_RATIO', 100);
}

(function () {
    $extensions = array_flip(get_loaded_extensions());
    if (!isset($extensions['curl']) || !isset($extensions['igbinary']) || !isset($extensions['event'])) {
        fwrite(STDERR, 'You need to enable extensions: `curl`, `igbinary`, `event`');
        exit(1);
    }
})();

require 'vendor/autoload.php';

$application = new Symfony\Component\Console\Application();

$application->setName('Container Helper');

$application->add(new ContainerHelper\Command\ConfigureCommand());
$application->add(new ContainerHelper\Command\LogCommand());
$application->add(new ContainerHelper\Command\RestartServices());

$application->run();
