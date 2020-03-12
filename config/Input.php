<?php
  class Input {
    public function post($key = null) {
      $output = null;
      if (isset($_POST) && !empty($_POST)) {
        $output = $_POST;
        if ($key !== null) {
          $output = isset($_POST[$key]) ? $_POST[$key] : null;
        }
      }

      return $output;
    }

    public function get($key = null) {
      $output = null;
      if (isset($_GET) && !empty($_GET)) {
        $output = $_GET;
        
        if ($key !== null) {
          $output = isset($_GET[$key]) ? $_GET[$key] : null;
        }
      }

      return $output;
    }
  }
?>