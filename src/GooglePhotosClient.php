<?php
  require_once dirname(__DIR__).'/src/GoogleSearch.php';
  require_once dirname(__DIR__).'/src/GoogleSearchResult.php';
  
  class GooglePhotos {
    public $result = []; 

    public function __construct() {
      $this->input = new Input();
    }

    public function init() {
      $search = trim($this->input->post('search'));

      if ($search) {

        $GoogleSearch = new GoogleSearch();
        $GoogleSearch->find($search);

        if(empty($GoogleSearch->result)) {
          $GoogleSearch->add($search);
          $this->result = $this->getResult($search);
        }

        $GoogleSearchResult = new GoogleSearchResult();
        if (!empty($GoogleSearch->result)) {
          $GoogleSearchResult->findBySearchId($GoogleSearch->result[0]['id']);
          $this->result = $GoogleSearchResult->result;
        }

        if ($GoogleSearch->lastInsertId) {
          foreach ($this->result as $row) {
            $GoogleSearchResult->image = $row['image'];
            $GoogleSearchResult->search_id = $GoogleSearch->lastInsertId;
            $GoogleSearchResult->add();
          }
        }        
      }
    }

    public function getResult($search) {
      
      $htmlOutput = $this->getHtmlOutput($search);
      $parsedOutput = $this->parseOutput($htmlOutput);
      
      $result = [];
      $counter = 0;
      foreach ($parsedOutput as $image) {

        if ($counter === 10) {
          break;
        }
        
        $src = $image->value;

        if (strpos($src, 'http') > -1  || strpos($src, 'https') > -1 ) {
          $newImage = $this->imageSaveToLocalDir($src);
          $result[] = [
            'image' => $newImage
          ];

          ++$counter;
        }
      }

      return $result;
    }

    private function imageSaveToLocalDir($url) {
      $image = file_get_contents($url);
      $filePath = $_SERVER['DOCUMENT_ROOT'].'/GooglePhotoScript/images/';
      $fileName = time().str_shuffle(time()).'.jpg';
      
      file_put_contents($filePath.$fileName, $image);
      return $fileName;
    }

    private function parseOutput($htmlOutput) {
      $doc = new DOMDocument();
      @$doc->loadHTML($htmlOutput);
      
      $xpath = new DomXPath($doc);
      return $xpath->query("//table/tr/td/a/img/@src");
    }

    private function getHtmlOutput($search) {
      $search = urlencode($search);
      $url = "https://www.google.com/search?q=".$search."&tbm=isch";
      return $this->file_get_content_curl($url);
    }

    private function file_get_content_curl($url) {
      $ch = curl_init();
      curl_setopt ($ch, CURLOPT_URL, $url);
      curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
      curl_setopt ($ch, CURLOPT_HEADER, 0);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($ch, CURLOPT_REFERER, 'http://www.google.com/');
      $result = curl_exec ($ch);
      curl_close ($ch);
      return $result;
    }

  }
?>