<?php
/**
 * Simple Rest 
 * 
 * 
 * @package    SimpleRest
 * @subpackage Controller
 * @author     J Wolfe <odwolfe@yahoo.com>
 */

require_once 'SimpleRestAPI.class.php';
require_once 'SimpleRestAuthUtil.class.php';
require_once 'SimpleRestDataHandler.class.php';

class SimpleRestServer extends SimpleRestAPI {
  protected $auth;
  protected $settings;

  public function __construct($request, $settings) {
    parent::__construct($request);
    $this->settings = $settings;
  }

  protected function authRequest($args) {
    $authenticated = false;
    $user = $args[0];
    if (!isset($this->settings['api_auth'][$user])) {
      throw new Exception('Invalid User');
    }
    else {
      $api_key = isset($args[1]) ? $args[1] : '';
      if (empty($api_key)) {
        throw new Exception('No API Key provided');
      }
      else {
        $secret = $this->settings['api_auth'][$user]['secret'];
        $token  = $this->settings['api_auth'][$user]['token'];
        $auth_util = new SimpleRestAuthUtil($secret, $token);
        if (!$auth_util->authAPIKey($api_key)) {
          throw new Exception('Invalid API Key');
        }
        else {
          $authenticated = true;
        }
      }
    }
    return $authenticated;
  }

  /**
   * Response method from a request verb
   * TODO: put this in a derived class
   */
  protected function myrequest($params) {
    if ($this->authRequest($params)) {
      $db_type  = 'mydb';
      return $this->getLibraryData($db_type);
    }
  }

  protected function auth($args) {
    $authenticated = false;
    $user = $args[0];
    if (!isset($this->settings['api_auth'][$user])) {
      throw new Exception('Invalid User');
    }
    else {
      $api_key = isset($args[1]) ? $args[1] : '';
      if (empty($api_key)) {
        throw new Exception('No API Key provided');
      }
      else {
        $secret = $this->settings['api_auth'][$user]['secret'];
        $token  = $this->settings['api_auth'][$user]['token'];
        // Abstracted out for example
        $auth_util = new SimpleRestAuthUtil($secret, $token);
        if (!$auth_util->authAPIKey($api_key)) {
          throw new Exception('Invalid API Key');
        }
        else {
          $authenticated = true;
        }
      }
    }
    return $authenticated;
  }

  protected function getLibraryData($db_type) {
    $rows = array();
    $tbl_type = $this->verb;
    $handler  = new SimpleRestDataHandler($this->settings, $db_type);
    $sql      = $handler->getSqlQuery($tbl_type, $this->args);
    $results  = $handler->query($sql);
    if ($results) {
      while($res = $handler->fetchAssoc($results)) {
        $rows[$tbl_type][] = $res;
      }
    }
    return $rows;
  }

  public function processAPI() {
    if (method_exists($this, $this->endpoint)) {
      return $this->_response($this->{$this->endpoint}($this->args));
    }
    return $this->_response("No Endpoint: $this->endpoint", 404);
  }
}