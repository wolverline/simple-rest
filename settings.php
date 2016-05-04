<?php
/**
 * Simple Rest 
 * 
 * 
 * @package    SimpleRest
 * @subpackage settings.php
 * @author     J Wolfe <odwolfe@yahoo.com>
 */

$settings['db'] = array(
  'mydb' => array (
    'driver' => 'mysql',
    'database' => 'mydb',
    'username' => 'root',
    'password' => 'root',
    'host' => 'localhost',
    'port' => '3306',
    'prefix' => '',
  ),
);

$settings['api_auth'] = array(
  'restuser' => array(
    'secret' => '@mykey',
    'token'  => 'C0F37A731E7640D465C09BE672BA67B2',
  ),
);