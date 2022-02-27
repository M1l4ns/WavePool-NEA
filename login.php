<?php
  session_start();
  include('db.php');
  
  date_default_timezone_set('Europe/Berlin');
  $email = "";
  $errors = array();

  if (isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($password)){
      array_push($errors, "Password Required");
    }
    if (empty($email)){
      array_push($errors, "Email Required");
    }

    if (count($errors)==0){
      $password = md5($password);
      $query = "SELECT * FROM signup WHERE Email='$email' AND Password='$password'";
      $result = mysqli_query($conn,$query);
      if (mysqli_num_rows($result)==1){
        $query2 = "UPDATE signup SET Online = TRUE WHERE Email='$email' AND Password='$password'";
        $result2 = mysqli_query($conn,$query2);
        $query3 = "SELECT fullName FROM signup WHERE Email='$email'";
        $result3 = mysqli_query($conn,$query3);
        $userName = mysqli_fetch_array($result3);
        $_SESSION['email']=$email;
        $_SESSION['fullName']=$userName["fullName"];
        $_SESSION['success']="You Are Logged In";
        header('location: Profile.php');
      }
      else{
        array_push($errors, "Incorrect Details...");
        header('location: login.php');
      }

    }
    else{
	    echo "Login Unsuccessfull";
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WavePool Login</title>
  <head>
    
  <link rel="stylesheet" href="./style.css">
  <title>Login page</title>

  <div class="main">
    <div class="container">
    <div class="logoImage">
      <img src="./wavepool dark2 - Copy.png" alt="Logo">
    </div>
      <div id="square">
        <div class="Login">
          <h1>Login</h1>
            <form action="#" method="post">
              <input required type="email" name="email" id="email" placeholder="Email"/>
              <input required type="password" name="password" id="password" placeholder="Password"/>
              <button type="submit" class = "submit" name="submit" id="submit">Submit</button>
              <meta http-equiv="refresh" content="time; URL=/signup.html" />
            </form>
            Not Signed Up? <a href="signup.php">Sign Up Here</a>
          </div>
        </div>