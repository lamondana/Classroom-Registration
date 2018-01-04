<?php
$PageName = "Teachers menu";
	include 'includes/header1.php'; // includes header

?>


    <main role="main" id="content">
        <div>
            <nav id="commonLinks" role="navigation">
            
                    <a href="menu.php"  id="menubutton" class="round-button">Home</a>
                    <a href="login.php"  id="logoutbutton" class="round-button">Log out</a>
                
           
        </nav>
            <img id="logo" src="images/TimeFirstLogo.png" alt="logo" width="177" height="106">

        </div>
        <div id="date">
            <?php
echo "Today is " .date("l")."  " .date("d/m/Y") . "<br>";?>
        </div>
        <div id="buttonsid1">
            <a href="classroom.php?classroom=1" id="button1" class="round-button">Classroom 1</a>

            <a href="classroom.php?classroom=2" id="button2" class="round-button">Classroom 2</a>



        </div>
    <?php
include 'includes/footer.php';
?>
