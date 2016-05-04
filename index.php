<?php
/**
 * Simple Rest 
 * 
 * 
 * @package    SimpleRest
 * @subpackage Controller
 * @author     J Wolfe <odwolfe@yahoo.com>
 */

require_once 'settings.php';
require_once 'SimpleRestServer.class.php';

// TODO::if checking origin header necessary, use HTTP_ORIGIN header
// if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
//     $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
// }
// $restlib = new SimpleRestLibrary($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);

try {
  $request = $_REQUEST['request'];
  $restlib = new SimpleRestServer($request, $settings);
  print $restlib->processAPI();
}
catch (Exception $e) {
  print json_encode(array('error' => $e->getMessage()));
}
