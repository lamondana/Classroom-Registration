<?php
$PageName = "Cookmenu";
	include 'includes/header1.php'; // includes header

?>

    <main id="content">

        <div>
            <nav id="commonLinks" role="navigation">

                <a href="menu.php" id="menubutton" class="round-button">Home</a>
                <a href="login.php" id="logoutbutton" class="round-button">Log out</a>


            </nav>
            <img id="logo" src="images/TimeFirstLogo.png" alt="logo" width="177" height="106">

        </div>
        <div id="date">
            <?php
echo "Today is " .date("l")."  " .date("d/m/Y") . "<br>";?>
        </div>
        <div id="buttonsid">


            <a href="cookreport.php" id="button3"  class="round-button" >Pupils</a>

        </div>

    <?php
include 'includes/footer.php';
?>
