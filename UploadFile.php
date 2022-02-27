<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') 
  {
    if (is_uploaded_file($_FILES['user_file']['tmp_name'])) 
    { 

  	  if(!empty($_FILES['user_file']['name']))
  	  {
        $upload_file_name = $_FILES['user_file']['name'];
  	    if(strlen ($upload_file_name)<100)
  	    {
          $info = pathinfo($_FILES['user_file']['name']);
          $ext = $info['extension'];
          $newname = "userSound.".$ext; 
          
          $dest=__DIR__.'/userSound/'.$newname;
          if (move_uploaded_file($_FILES['user_file']['tmp_name'], $dest)) 
          {
    	      echo 'File Uploaded';
          }
          
          require_once('pythonExecute.php');

          session_start();
          include('db.php');
          date_default_timezone_set('Europe/Berlin');
          $fileID = fopen("fingerPrint.txt", "r");
          $fileID = fgets($fileID);

          $filePitch = fopen("pitchData.txt", "r");
          $filePitch = fgets($filePitch);
          $userName = $_SESSION['fullName'];
          $errors = array();

          $queryID = "SELECT UserID FROM signup WHERE fullName = '$userName'";
          $resultID = mysqli_query($conn,$queryID);
          $userID = mysqli_fetch_array($resultID);
          $userID = $userID["UserID"];

          $queryH = "SELECT UploadDate FROM data WHERE FileId = '$fileID'";
          $resultH = mysqli_query($conn,$queryH);

          if((mysqli_num_rows($resultH)!=1)){
            $query = "INSERT INTO data(UserID,UploadDate, FileId, filePitch) VALUES($userID,NOW(), '$fileID','$filePitch')";
            $result = mysqli_query($conn,$query);
          }
          else{
            echo "<b> | File Already Exists</b>";
          }
  	  }
    }
  }
}
?>

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
    <a id="nav-a" class="active" href="UploadFile.php">Copyright File Check</a>
    <a id="nav-b" href="FileShare.php">File Share</a>
    <a id="nav-c" href="Search.php">Search</a>
    <a id="nav-d" href="Profile.php">Profile</a>
  </div>

  <div class="main">
    <div class = "container">
      <div class = "element">
        <form action="UploadFile.php" name="form" method="post" enctype="multipart/form-data">
          <label for="user_file"><b>Upload your audio file: </b></label><br><br>
          <input id="user_file" name="user_file" type="file" onchange="fileReader(this.files);">
          <input id="submitAudio" type="submit" name="submit" value="Upload" style="height:30px; width:100px;"/>
          <div class = "sumData">
            <br></br>
            <label id="fingerPrint"><b>!!!</b>
            <?php
              $myfilename = "fingerPrint.txt";
              $_SESSION['myfilename']=$myfilename;
              if(file_exists($myfilename)){
                echo file_get_contents($myfilename);
              }
            ?>
            </label>
            <br></br>
            <label id="pitchData"><b>!!!</b>
            <?php
              $myfilename2 = "pitchData.txt";
              $_SESSION['myfilename2']=$myfilename2;
              if(file_exists($myfilename2)){
                echo file_get_contents($myfilename2);
              }
            ?>
            </label>
            <script>
              var delayTime = 2000;
              setTimeout(function() {
                
              }, 
              delayTime);
            </script>
            
            <div class = "graphz">
              <br></br>
              <img class = "image" src="graph1.png" alt="image"/>
              <br></br>
              <img class = "image" src="graph2.png" alt="image"/>
              <br></br>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
	  function fileReader(files) {
		  var fileReader = new FileReader();
			  fileReader.readAsArrayBuffer(files[0]);
			  fileReader.onload = function(e) {
				  //audioFilePlayer(e.target.result);
				  console.log(("Filename: '" + files[0].name + "'"), ( "(" + ((Math.floor(files[0].size/1024/1024*100))/100) + " MB)" ));
			  }
	  }
	  function audioFilePlayer(file) {
		  var context = new window.AudioContext();
			  context.decodeAudioData(file, function(buffer) {
				  var source = context.createBufferSource();
					  source.buffer = buffer;
					  source.loop = false;
					  source.connect(context.destination);
					  source.start(0); 
			  });
	  }
  </script>
