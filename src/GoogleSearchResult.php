<?php
  require_once dirname(__DIR__).'/config/DBConnection.php';

  class GoogleSearchResult {
    public $table = 'gp_results';
    public $search_id = '';
    public $image = '';

    public function __construct() {
      $this->conn = DB::getConnection();
    }

    public function findBySearchId($search_id) {
      $query = 'SELECT * FROM '. $this->table . ' WHERE search_id = ?';
      $params = [$search_id];
      $stmt = $this->prepareAndExecute($query, $params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function add() {
      $query = "INSERT INTO ". $this->table . " (id , search_id, image) VALUES (?, ?, ?) ";
      $params = [null, $this->search_id, $this->image];
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