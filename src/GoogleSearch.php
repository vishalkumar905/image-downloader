<?php
  require_once dirname(__DIR__).'/config/DBConnection.php';

  class GoogleSearch {
    public $table = 'gp_search';
    public $text = '';
    public $result = [];
    public $lastInsertId = null;

    public function __construct() {
      $this->conn = DB::getConnection();
    }

    public function find($search) {
      $query = 'SELECT * FROM '. $this->table . ' WHERE search = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$search]);
      $this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function add($search) {
      $query = "INSERT INTO ". $this->table . " (id , search) VALUES (?, ?) ";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([null, $search]);
      $this->lastInsertId = $this->conn->lastInsertId();
    }
  }
?>