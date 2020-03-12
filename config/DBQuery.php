<?php
  require_once 'DBConnection.php';

  class DBQuery {
    public $pdo = null;

    public function __construct() {
      $this->pdo = DB::getConnection();
    }

    public function select($table, $condition = null) {
      $query  = 'SELECT * FROM '. $table;

      if (!empty($condition)) {
        $query .= ' WHERE ';

        foreach ($condition as $key => $value) {
          $query .= $key . ' = ? ' . $value;
          
          $query .= ' AND ';

        }
      }

      echo $query;


    }

    public function insert() {

    }

    public function query() {

    }
  }

  $DBQuery = new DBQuery();
?>