<?php
namespace App\Database;

use mysqli;

class MySQLConnectionConfiguration 
{
 
  private static MySQLConnectionConfiguration | null $instance = null;
  private mysqli $connection;

  private function __construct()
  {
    $this->connection = new mysqli(
      getenv("DB_HOST"),
      getenv("DB_USER"),
      getenv("DB_PASSWORD"),
      getenv("DB")
    );
    
    if($this->connection->connect_errno)
      die("Connection failed! " . $this->connection->connect_error);
  }

  public static function getInstance(): MySQLConnectionConfiguration 
  {
    if(self::$instance === null) 
      self::$instance = new MySQLConnectionConfiguration();
    return self::$instance;
  }

  public function getConnection(): mysqli 
  {
    return $this->connection;
  }
}
