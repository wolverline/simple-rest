<?php
/**
 * Simple Rest 
 * 
 * 
 * @package    SimpleRest
 * @subpackage Controller
 * @author     J Wolfe <odwolfe@yahoo.com>
 */

class SimpleRestDataHandler {
  protected $config;
  protected $dbcon;
  protected $queries;

  public function __construct($settings, $dbtype) {
    $this->config  = array();
    $this->queries = array();
    $this->config = $this->getConfig($settings, $dbtype);
    $this->connectDB();
  }

  protected function getConfig($settings, $dbtype) {
    $config = array();
    if (isset($settings['db'][$dbtype])) {
      $config = $settings['db'][$dbtype];
    }
    return $config;
  }

  public function connectDB() {
    $host     = $this->config['host'];
    $username = $this->config['username'];
    $password = $this->config['password'];
    $database = $this->config['database'];
    $port     = $this->config['port'];
    $dbcon = mysqli_connect($host, $username, $password, $database, $port);
    if (mysqli_connect_errno()) {
      throw new \Exception('Connect failed. ' . mysqli_connect_error());
    }
    $this->dbcon = $dbcon;
  }

  public function getSqlQuery($tbl_name, $params = array()) {
    $query = '';
    switch ($tbl_name) {
      case 'mytable':
        $query = 'SELECT * FROM ' . $tbl_name;
        if (array_key_exists(2, $params) && is_numeric($params[2])) {
          $param = $params[2];
          $d_timestamp = strtotime("- $param days");
          $interval = date('Y-m-d H:i:s', $d_timestamp);
          $query = $this->addCondition($query, 'updated_date', $interval, '>=');
        }
        $query .= ';';
        break;
      default:
        $query = 'SELECT * FROM ' . $tbl_name . ';';
        break;        
    }
    return $query;
  }

  public function query($sql) {
    $dbcon = $this->dbcon;
    return mysqli_query($dbcon, $sql);
  }

  public function fetchAssoc($result) {
    return mysqli_fetch_assoc($result);
  }

  public function fetchRow($result) {
    return mysqli_fetch_row($result);
  }

  public function insertId($result) {
    return mysqli_insert_id($this->dbcon);
  }

  public function affectedRows($result) {
    return mysqli_affected_rows($this->dbcon);
  }

  public function close($result) {
    return mysqli_free_result($result);
  }

  public function addCondition($sql, $field_name = '', $condition = '', $cond_type = '=') {
    if (!empty($field_name) && !empty($condition)) {
      return "$sql WHERE $field_name $cond_type '$condition'";
    }
    return $sql;
  }

  public function addLimitToSql($sql, $limit, $offset) {
    return "$sql LIMIT $limit OFFSET $offset";
  }

  public function likeEscape($string) {
    return addcslashes($string,'%_');
  }

  public function base64Encode($string) {
    return base64_encode($string);
  }

  public function getDefaultCharset() {
    return 'utf8';
  }
}