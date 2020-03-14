<?php
  include_once 'config/Input.php';
  include_once 'src/GooglePhotosClient.php';
  
  $Input = new Input();
  $GooglePhotos = new GooglePhotos();
  $getAllResult = $GooglePhotos->init();

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
                  <button class="btn btn-default" value='Search'  type="submit">Search</button>
                </div>
              </div>
            </form>
          </div>

          <div class='result'>
            <?=$GooglePhotos->getResultMessage($Input->post('search'), $getAllResult)?>
            
            <?=$GooglePhotos->showResults($getAllResult)?>
          </div>
        </div>
      </div>
    </body>
  </html>
</DOCTYPE>