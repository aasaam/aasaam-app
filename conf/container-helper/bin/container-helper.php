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

if (!defined('PHAR_VERSION')) {
    define('PHAR_VERSION', 'v' . gmdate('y.n.j'));
}

(function () {
    $extensions = array_flip(get_loaded_extensions());
    if (!isset($extensions['curl']) || !isset($extensions['event'])) {
        fwrite(STDERR, 'You need to enable extensions: `curl`, `event`');
        exit(1);
    }
})();

function random_string()
{
    $hex = bin2hex(openssl_random_pseudo_bytes(10));
    $base62 = preg_replace('/[^a-z0-9]/i', '', base64_encode($hex));
    return substr($base62, 0, 16);
}

if (defined('PHAR_MODE')) {
    define('ROOT_PATH', 'phar://container-helper.phar');
} else {
    define('ROOT_PATH', dirname(__DIR__));
}

require ROOT_PATH . '/vendor/autoload.php';

ContainerHelper\Config::init();

$application = new Symfony\Component\Console\Application();

$application->setName('Container Helper');
$application->setVersion(PHAR_VERSION);

$application->add(new ContainerHelper\Command\ConfigCommand());
$application->add(new ContainerHelper\Command\LogCommand());
$application->add(new ContainerHelper\Command\StatusCommand());

$application->run();
