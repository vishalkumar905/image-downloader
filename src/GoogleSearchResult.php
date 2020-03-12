<?php
  require_once dirname(__DIR__).'/config/DBConnection.php';

  class GoogleSearchResult {
    public $table = 'gp_results';
    public $result = [];
    public $search_id = '';
    public $image = '';

    public function __construct() {
      $this->conn = DB::getConnection();
    }

    public function findBySearchId($search_id) {
      $query = 'SELECT * FROM '. $this->table . ' WHERE search_id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$search_id]);
      $this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function add() {
      $query = "INSERT INTO ". $this->table . " (id , search_id, image) VALUES (?, ?, ?) ";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([null, $this->search_id, $this->image]);
      return $this->conn->lastInsertId();
    }
  }
?>