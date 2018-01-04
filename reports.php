<?php
session_start();
$PageName = "Reports";
include 'includes/header1.php'; // includes header
//display all php errors on the browser
ini_set('display_errors', '1'); 	
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
echo "Today is " .date("l"). "<br>". date("d/m/Y") . "<br>";?>
        </div>

        <form id="reportDate" method="post" action="adminreport.php">

            <fieldset>
                <legend>Report for:</legend>

                <div class="inputForm">Date
                    <br>
                    <input id="ReportDate" name="ReportDate" value="yyyy-mm-dd" type=date>
                </div>
                <div class="inputForm">Classroom
                    <br>
                    <input name="Classroom" type=t ext>
                </div>
                <div class="inputForm">
                    <input type='submit' name='ReportDateSubmitForm' class="miniroudbutton" value='Submit'>
                </div>

            </fieldset>
        </form>

    <?php
include 'includes/footer.php';
?>
