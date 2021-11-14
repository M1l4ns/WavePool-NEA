<?php
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $password = $_POST['password'];
    
    if (!empty($email)){
        if (!empty($fullName)){  
            if (!empty($password)){
                $host = 'localhost';
                $dbusername = 'root';
                $dbpassword = '';    
                $dbname = 'singupdetails';
                
                $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
                if($conn->connect_error){
                    die('Connection Failed :'.$conn->connect_error);
                }
                }
                else{
                    $stmt = $conn->prepare("INSERT INTO signupdetails(Email, fullName, Password) values(?,?,?)");
                    $stmt->bind-param("sss",$email,$fullName,$password);
                    $stmt->execute();
                    echo "confirmed";
                    $stmt->close();
                    $conn->close();
                }
            }
            else{
                echo "Password must be entered";
                die();
            }  
        }
        else{
            echo "Full name must be entered";
            die();
        }    
    }
    else{
        echo "Email must be entered";
        die();
    }
?>