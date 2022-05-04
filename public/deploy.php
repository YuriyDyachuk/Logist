<?php

file_put_contents('deploy.log', date('m/d/Y h:i:s a') . " deployed latest branch start" . "\n", FILE_APPEND);
// git
file_put_contents('deploy.log', date('m/d/Y h:i:s a') . " git pull start" . "\n", FILE_APPEND);

if (isset($_GET['branch']))
{
    $output = shell_exec('git pull origin '.$_GET['branch'].' 2>&1');
    file_put_contents('deploy.log', $output . "\n", FILE_APPEND);
    $output = shell_exec('git checkout '.$_GET['branch'].' 2>&1');
}
else
{
    $output = shell_exec('git pull origin dev 2>&1');
    file_put_contents('deploy.log', $output . "\n", FILE_APPEND);
    $output = shell_exec('git checkout dev 2>&1');
}

file_put_contents('deploy.log', $output . "\n", FILE_APPEND);

file_put_contents('deploy.log', date('m/d/Y h:i:s a') . " git pull end" . "\n", FILE_APPEND);
//composer
file_put_contents('deploy.log', date('m/d/Y h:i:s a') . " composer update start" . "\n", FILE_APPEND);

chdir('..');

putenv('COMPOSER_HOME=' . __DIR__ . '/');

$output = shell_exec('php composer.phar update 2>&1');

chdir('public');

file_put_contents('deploy.log', $output . "\n", FILE_APPEND);

file_put_contents('deploy.log', date('m/d/Y h:i:s a') . " composer update end" . "\n", FILE_APPEND);
//migrate
file_put_contents('deploy.log', date('m/d/Y h:i:s a') . " artisan migrate start" . "\n", FILE_APPEND);

chdir('..');

$output = shell_exec('php artisan migrate 2>&1');

chdir('public');

file_put_contents('deploy.log', $output . "\n", FILE_APPEND);

file_put_contents('deploy.log', date('m/d/Y h:i:s a') . " artisan migrate end" . "\n", FILE_APPEND);

file_put_contents('deploy.log', date('m/d/Y h:i:s a') . " deployed latest branch stop" . "\n", FILE_APPEND);

?>