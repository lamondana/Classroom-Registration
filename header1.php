<?php
session_start();
$i = intval($_SESSION["UserID"]);
if ($i < 1) {
    header( 'Location: login.php');
    die();
}

echo '
<!DOCTYPE html>
<html>

<head>
<script type="text/javascript" src="myscript.js"></script>
    <meta charset="utf-8">
    <title> '. $PageName.' </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
   
    <script type="text/javascript" src="jquery-1.8.3.js"></script>
</head>

<body>
    <header id="mainHeader" role="banner">
        
    </header>
            
'
?>