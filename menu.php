

<?php

$PageName = "Menu";
include 'includes/header1.php'; // includes header

?>


    <main role="main" id="content">
        <div>
           <nav id="commonLinks" role="navigation">
            
                   
                    <a href="login.php"  id="logoutbutton" class="round-button">Log out</a>
                
           
        </nav>
            <img id="logo" src="images/TimeFirstLogo.png" alt="logo" width="177" height="106">

        </div>
        <div id="date">
            <?php
echo "Today is " .date("l")."  " .date("d/m/Y") . "<br>";?>
        </div>
        <div id="buttonsid1">
            <a href="teachermenu.php" id="button1" class="round-button">Teachers</a>
            <a href="adminmenu.php" id="button2" class="round-button">Admin</a>
            <a href="cookmenu.php" id="button3" class="round-button">Kitchen</a>

        </div>


   
    <?php
include 'includes/footer.php';
?>
