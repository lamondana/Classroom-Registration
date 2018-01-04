<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

session_start();
$errorcredentials="";

// Login
if(isset($_POST['submitbutton'])){//Do validation
    $form_is_submitted = true;
    //validation for the  childname
    if(isset($_POST['username'])){
        //if the imput for fullmane is not empty
        $tempname = $_POST['username'];
        if(!empty($tempname)){
            
			$username	= $_POST["username"];
			$password	= $_POST["password"];

            $db = new PDO('mysql:host=localhost;dbname=iotops27_anaproject;charset=utf8', 'iotops27_sk', 'flunjstics43,21');
            //Query to check if the username and password are correct on the dataase
			$sSQL = "select *	
					from users 
					where Username = :username
					  and Password = :password"; 
			// binding the parameters
			$stmt = $db->prepare($sSQL);    
			$stmt->bindParam(':username', $username, PDO::PARAM_STR); 
			$stmt->bindParam(':password', $password, PDO::PARAM_STR); 
			$stmt->execute();

			if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$UserID      = $row["UserID"]; 
			} else {
				$UserID      = -1; 
                $errorcredentials="Wrong credentials";
			}

            $_SESSION["UserID"] = $UserID;

            //var_dump($_SESSION);
            if ($UserID > -1) {
                header('Location: http://iotops.net/anaproject/menu.php');
            }
            
        }
            
    }
} else {
    session_destroy();
}

?>

<!DOCTYPE html>
<!--Created by Ana Cebrian Eroles -->
<html>

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="jquery-1.8.3.js"></script>
    <script type="text/javascript" src="myscript.js"></script>
    
</head>

<body>
    <header id="mainHeader" >
        
    </header>
            <main  id ="content">
    <div>
    <img id="logo" src="images/TimeFirstLogo.png" alt="logo" width="177" height="106">
                </div>
    <div id="date"><?php
echo "Today is " .date("l")."  " .date("d/m/Y") . "<br>";?>
            </div>
    <div class='form'>
        <form action="login.php" id="uselogin" method="post">
            <fieldset>
                <legend>Login</legend>

                <div class="divform">
                    <label for="username">Username:</label>
                    <input aria-required="true" type="text" name="username" id="username" value="" />
                </div>
                <div class="divform">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" value="" />
                </div>
                <div id="errorcredentials"><?php  echo $errorcredentials ?></div>
                <div class="divform">
                <input type="submit"  class="miniroudbutton"  name="submitbutton" value="submit" />
                </div>
                

            </fieldset>
        </form>
        
    </div>
<?php
include 'includes/footer.php';
?>