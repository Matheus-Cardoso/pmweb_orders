<?php

class Database_Conn {

  private $connection_string;

  function __construct() {
    $this -> connection_string = mysqli_connect("MYSQL_HOSTNAME", "MYSQL_USERNAME", "MYSQL_PASSWORD", "MYSQL_DATABASE");
  }

  function DBConnection() {
    return $this -> connection_string;
  }

}

?>