<?php
  session_start();
  include('db.php');

  date_default_timezone_set('Europe/Berlin');
  $fullName = "";
  $email = "";
  $errors = array();

  if (isset($_POST['submit'])){
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rating = 5;

    if (empty($fullName)){
      array_push($errors, "Full Name Required");
    }
    if (empty($email)){
      array_push($errors, "Email Required");
    }

    if (count($errors)==0){
      $password = md5($password);
      $sql = "INSERT INTO signup(fullName, Email, Password, DateCreated, Rating) VALUES('$fullName', '$email','$password', NOW(),'$rating')";
      mysqli_query($conn, $sql);
      echo "Registered Successfully";
      $_SESSION['fullName']=$fullName;
      $_SESSION['success']="You Are Logged In";
      header('location: Profile.php');
    }
    else{
	    echo "Register Unsuccessfull";
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WavePool Sign Up</title>
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
          <h1>Sign Up</h1>
            <form action="signup.php" method="POST" name = "register">
              <input required type="email" name="email" id="email" placeholder="Email"/>
              <input required type="text" name="fullName" id="fullName" placeholder="Full name"/>
              <input required type="password" name="password" id="password" placeholder="Password"/>
              <button type="submit" class = "submit" name="submit" id="submit">Submit</button>
            </form>
            <p>
            Already Signed Up? <a href="login.php">Sign In Here</a>
            </p>
          </div>
        </div>