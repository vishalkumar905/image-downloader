<?php
  require_once dirname(__DIR__).'/config/DBConnection.php';

  class GoogleSearch {
    public $table = 'gp_search';
    public $text = '';

    public function __construct() {
      $this->conn = DB::getConnection();
    }

    public function find($search) {
      $query = 'SELECT * FROM '. $this->table . ' WHERE search = ?';
      $params = [$search];
      $stmt = $this->prepareAndExecute($query, $params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function add($search) {
      $query = "INSERT INTO ". $this->table . " (id , search) VALUES (?, ?) ";
      $params = [null, $search];
      $stmt = $this->prepareAndExecute($query, $params);
      return $this->conn->lastInsertId();
    }

    private function prepareAndExecute($query, $params) {
      $stmt = $this->conn->prepare($query);
      $stmt->execute($params);
      return $stmt;
    }
  }
?>