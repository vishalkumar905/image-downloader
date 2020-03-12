<?php
  require_once('Constant.php');

  class DB {
    static function getConnection() {
      $conn = null;

      try {
        $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo 'There is some problem in connection: '. $e->getMessage();
        exit;
      }
      
      return $conn;
    }
  }
?>