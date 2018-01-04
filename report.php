<?php
//display all php errors on the browser
ini_set('display_errors', '1'); 	
include 'includes/header.php'; // includes header
// user reportdate
$thedate = $_POST["ReportDate"];

$db = new PDO('mysql:host=localhost;dbname=iotops27_anaproject;charset=utf8', 'iotops27_sk', 'flunjstics43,21');
//request all pupil details of the actual for the requested date
$sSQL = " Select * from actual a, pupil p where p.pupilID = a.pupilID and a.TheDate = :thedate "; 
// asking mysql to prepare and check the request $sSQL if it works carry on if not show the error
$stmt = $db->prepare($sSQL) or die("Select Failed ".mysql_error());
//provide a value for the parameter in the sql
$stmt->bindParam(':thedate', $thedate, PDO::PARAM_STR); 
//execute the sql
$stmt->execute(); 

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
}

$stmt->close();

    
?>
