<?php
/**
 * Simple Rest 
 * 
 * 
 * @package    SimpleRest
 * @subpackage Controller
 * @author     J Wolfe <odwolfe@yahoo.com>
 */

class SimpleRestAuthUtil {
  private $secret;
  private $token;
  private $auth;

  public function __construct($secret, $token) {
    $this->secret = $secret;
    $this->token  = $token;
  }

  private function generateBase64sha256() {
    $hashkey = '';
    if (!empty($this->secret) && !empty($this->token)) {
      $hashkey = base64_encode(hash_hmac('sha256', $this->secret, $this->token, false));
    }
    return $hashkey;
  }

  public function setSecret($secret) {
    $this->user = $secret;
  }

  public function setToken($token) {
    $this->token = $token;
  }
  
  public function generateToken($str) {
    $token = '';
    if (!empty($str)) {
      $token = md5($str);
    }
    return $token;
  }

  public function authAPIKey($hashedkey) {
    $hashkey = $this->generateBase64sha256();
    $b_success = $hashkey == $hashedkey;
    return $b_success;
  }
}
