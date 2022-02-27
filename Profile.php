<?php
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WavePool Profile</title>
  <head>
    
  <link rel="stylesheet" href="./style2.css">
  <title>Algorithm Page</title>


  <div class="navigation">
    <?php 
      session_start();
      $userName = $_SESSION['fullName'];
      if (isset($userName)):?>
        <a href="UploadFile.php">Copyright File Check</a>
        <a href="FileShare.php">File Share</a>
        <a href="Search.php">Search</a>
        <a class="active" href="Profile.php">Profile</a>
        <a>WELCOME: <?php echo $userName;?></a>
    <?php endif ?>
  </div>

  <div class="main" >
      <div class = "container">
        <div class = "element">
          <b><?php echo $userName; ?></b>
          <div class = "box">
            <img src="./DefaultProfile2.png" alt="Profile">
          </div>
            <label class = "textbox" for="followings"><b>Followers: 0</b></label>
            <label class = "textbox" for="followings"><b>Following: 0</b></label><br><br>

            <label id="userGraphs"><u><b>My Files</b></u>
          <div class = "graphz">
            <img class = "image" src="graph1.png" />
            <img class = "image" src="graph2.png" />
          </div>
        </div>
      </div>
  </div>