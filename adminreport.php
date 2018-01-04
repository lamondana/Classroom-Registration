<?php
    session_start();
	include 'includes/header1.php'; // includes header
    
    $db = new PDO('mysql:host=localhost;dbname=iotops27_anaproject;charset=utf8', 'iotops27_sk', 'flunjstics43,21');


    $Classroom = $_POST["Classroom"];
    $TheDate   = $_POST["ReportDate"];

    $sSQL = "select * 
             from actual a, pupils p 
             where p.Classroom = :class
               and a.Date = :thedate
               and a.pupilid = p.pupilid
            "; 
    
    $stmt = $db->prepare($sSQL);    
    $stmt->bindParam(':class', $Classroom, PDO::PARAM_INT); 
    $stmt->bindParam(':thedate', $TheDate, PDO::PARAM_STR); 
    $stmt->execute();
    
    
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
            
                    <a href="menu.php"  id="menubutton" class="round-button">Home</a>
                    <a href="login.php"  id="logoutbutton" class="round-button">Log out</a>
                
           
        </nav>
            <img id="logo" src="images/TimeFirstLogo.png" alt="logo" width="177" height="106">

        </div>
        <div id="date">
            <?php
echo "Today is " .date("l"). "<br>". date("d/m/Y") . "<br>";?></div>
        

        <div id="adminreport">

            <table>
                <caption>Report for:
                    <?php echo  $TheDate . " " .' Classroom' ." " .$Classroom ?>
                </caption>
                <tr>
                    <th>Name</th>
                    <th>Attendance</th>
                    <th>Circumstance</th>
                </tr>
                <?php
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        $pupilid = $row['PupilID'];
        $firstname = $row['Firstname'];
        $lastname = $row['Lastname'];
        $classroom = $row['Classroom'];
        $attendance = $row['Attendance'];
        $circumstances = $row['Circumstances'];        
        
?>
                    <tr>
                        <td>
                            <?php echo $firstname . ' ' . $lastname ?>
                        </td>
                        <td>
                            <?php echo $attendance?>
                        </td>
                        <td>
                            <?php echo $circumstances?>
                        </td>
                    </tr>
                    <?php } ?>
            </table>
<input type="button" onclick="printDiv('adminreport')" value="Print report"  class="round-button" id="printbutton"/>

        </div>

    </main>

    </body>


    </html>
