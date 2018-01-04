<?php
	session_start();
$PageName = "Cook report";
	include 'includes/header1.php'; // includes header
    
    $db = new PDO('mysql:host=localhost;dbname=iotops27_anaproject;charset=utf8', 'iotops27_sk', 'flunjstics43,21');

    $sSQL = "select *
             from actual a, pupils p
             where Attendance = 'Full Day'
               and a.Date = Cast(NOW() as DATE)
               and p.pupilid = a.pupilid"; 
    
    $stmt = $db->prepare($sSQL);    
    $stmt->execute();
    
    $Counter = 0;

?>
    <!--FILE?, H.
How do I link a JavaScript file to a HTML file?
In-text: (file?)
Your Bibliography: file?, How. "How Do I Link A Javascript File To A HTML File?". Stackoverflow.com. N.p., 2017. Web. 1 May 2017.-->

    <script type="text/javascript">
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

    </script>

    <main id="content">

        <div>
            <nav id="commonLinks" role="navigation">

                <a href="menu.php" id="menubutton" class="round-button">Home</a>
                <a href="login.php" id="logoutbutton" class="round-button">Log out</a>


            </nav>
            <img id="logo" src="images/TimeFirstLogo.png" alt="logo" width="177" height="106">

        </div>
        <div id="date">

        </div>

        <div id="todayReport">
            <table>
                <caption>Report for:
                    <?php  echo date("l"). " " .date("d/m/Y") ?>
                </caption>
                <tr>
                    <th>Name</th>
                    <th>Classroom</th>
                </tr>
                <?php
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
        $Counter += 1;
        $firstname = $row['Firstname'];
        $lastname = $row['Lastname'];
        $classroom = $row['Classroom'];      
        
?>
                    <tr>
                        <td>
                            <?php echo $firstname . ' ' . $lastname ?>
                        </td>
                        <td>
                            <?php echo $classroom?>
                        </td>

                    </tr>
                    <?php } 
                    
                    ?>
            </table>
            <div  id="errorcredentials">The total number of pupils for lunch is:
                <?php echo $Counter?>
            </div>

        </div>

        <input type="button" onclick="printDiv('todayReport')" value="Print report" class="round-button" id="printbutton" />

    <?php
include 'includes/footer.php';
?>
