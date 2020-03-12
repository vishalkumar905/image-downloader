<?php
  include_once 'config/Input.php';
  include_once 'src/GooglePhotosClient.php';
  
  $Input = new Input();
  $GooglePhotos = new GooglePhotos();
  $GooglePhotos->init();
?>

<!DOCTYPE html>
  <html>
    <head>
      <title>Google Pictures Downloader</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/bootstrap.min.css">
      <link rel='stylesheet' href='assets/custom.css' />
      <script src="assets/jquery.min.js" ></script>
      <script src="assets/bootstrap.min.js" ></script>
    </head>
    <body>
      <div class='container'>
        <div class='col-md-12'>
          <div class='searchbox'>
            <h3>Google Pictures Downloader</h3>
            <form action='' method='POST'>
              <div class="input-group">
                <input type="text" name='search' value='<?=$Input->post('search');?>' class="form-control" placeholder="Search">
                <div class="input-group-btn">
                  <button  class="btn btn-default" value='Search'  type="submit">Search</button>
                </div>
              </div>

            </form>
          </div>

          <div class='result'>
            <?php
              $message = '';
              if (!empty($Input->post('search'))) {
                $message .= 'Result: ';
                if (empty($GooglePhotos->result)) {
                  $message .= '<b>Not found </b>';
                } else if (!empty($GooglePhotos->result)) {
                  $message .= '<b>'.count($GooglePhotos->result).' pictures found</b>';
                }
              }
            ?>
            <br><p><?=$message?></p>
            <?php if (!empty($GooglePhotos->result)) { 
              foreach($GooglePhotos->result as $row) {  
            ?>
              <img class="img-thumbnail" src='images/<?=$row['image']?>'/>
            <?php } }?>
          </div>
        </div>
      </div>
    </body>
  </html>
</DOCTYPE>