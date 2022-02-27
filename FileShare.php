<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WavePool Algorithm</title>
  <head>
    
  <link rel="stylesheet" href="./style2.css">
  <title>Algorithm Page</title>


  <div class="navigation">
    <a href="UploadFile.php">Copyright File Check</a>
    <a class="active" href="FileShare.php">File Share</a>
    <a href="Search.php">Search</a>
    <a href="Profile.php">Profile</a>
  </div>

  <div class="main">
    <div class = "container">
      <div class = "element">
        <form action="UploadFile.php" name="form" method="post" enctype="multipart/form-data">
          <label for="user_file"><u><b>Select File To Send</b></u></label><br><br>
          <input id="user_file" name="user_file" type="file" onchange="fileReader(this.files);">
          <input id="submitAudio" type="submit" name="submit" value="Send" style="height:30px; width:100px;"/>
      </div>
    </div>
  </div>