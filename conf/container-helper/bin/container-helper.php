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

define('BOT_USERAGENT', 'AasaamBot/0.1');
if (getenv('DEBUG')) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    define('TIME_RATIO', 10);
} else {
    define('TIME_RATIO', 1000);
}

(function () {
    $extensions = array_flip(get_loaded_extensions());
    if (!isset($extensions['curl']) || !isset($extensions['event'])) {
        fwrite(STDERR, 'You need to enable extensions: `curl`, `event`');
        exit(1);
    }
})();

function random_string(int $length = 12)
{
    $hex = bin2hex(openssl_random_pseudo_bytes(8));
    $base62 = preg_replace('/[^a-z0-9]/i', '', base64_encode($hex));
    return substr($base62, 0, $length);
}

if (defined('PHAR_MODE')) {
    require 'phar://container-helper.phar/vendor/autoload.php';
} else {
    require 'vendor/autoload.php';
}

if (!defined('PHAR_VERSION')) {
    define('PHAR_VERSION', 'v' . gmdate('y.n.j'));
}

$application = new Symfony\Component\Console\Application();

$application->setName('Container Helper');
$application->setVersion(PHAR_VERSION);

$application->add(new ContainerHelper\Command\ConfigureCommand());
$application->add(new ContainerHelper\Command\LogCommand());
$application->add(new ContainerHelper\Command\RestartServices());
$application->add(new ContainerHelper\Command\SwooleCommand());

$application->run();
