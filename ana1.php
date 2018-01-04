<?php
ini_set('display_errors', 1);

$connstr = 'mysql:host=localhost;dbname=iotops27_anaproject;charset=utf8', 'iotops27_sk', 'flunjstics43,21';

function Login() {

    $username	= $_PAST["Username"];
    $password	= $_PAST["Password"];

    $db = new PDO($connstr);
 
	$sSQL = "select *	
	 		from users 
			where Username = :username
			  and Password = :password"; 
    // Print all pupils in database
    $stmt = $db->prepare($sSQL);    
    $stmt->bindParam(':username', $username, PDO::PARAM_STR); 
    $stmt->bindParam(':password', $password, PDO::PARAM_STR); 
    $stmt->execute();

    if ($row = $stmt->fetchall(PDO::FETCH_ASSOC))
    {
        $PupilID      = $row['PupilID']; 
    } else {
      	$PupilID      = -1; 
    }
    
    return $PupilID;
}


function AddPupil() {
    
    $name      = $_POST["Name"];
    $class     = $_POST["Class"];
    $monday    = $_POST["Monday"];
    $tuesday   = $_POST["Tuesday"];
    $wednesday = $_POST["Wednesday"];
    $thursday  = $_POST["Thursday"];
    $friday    = $_POST["Friday"];
    
    $db = new PDO($connstr);
 
	$sSQL = "insert into pupils 
			 (Name, Class, Monday, Tuesday, Wednesday, Thursday, Friday) 
			 VALUES (:name, :class, :monday, :tuesday, :wednesday, :thursday, :friday)"; 
    // Print all pupils in database
    $stmt = $db->prepare($sSQL);    
    $stmt->bindParam(':name', $name, PDO::PARAM_STR); 
    $stmt->bindParam(':class', $class, PDO::PARAM_INT); 
    $stmt->bindParam(':monday', $monday, PDO::PARAM_INT); 
    $stmt->bindParam(':tuesday', $tuesday, PDO::PARAM_INT); 
    $stmt->bindParam(':wednesday', $wednesday, PDO::PARAM_INT); 
    $stmt->bindParam(':thursday', $thursday, PDO::PARAM_INT); 
    $stmt->bindParam(':friday', $friday, PDO::PARAM_INT); 
    $stmt->execute();
	 
}

function AddUser() {
 
    $name      = $_PAST["Name"];
    $classroom = $_PAST["Classroom"];
    $username  = $_PAST["Username"];
    $password  = $_PAST["Password"];
    
    $db = new PDO($connstr);
 
	$sSQL = "insert into users 
			 (Name, Classroom, Username, Password) 
			 VALUES (:name, :classroom, :username, :password)"; 
    // Print all pupils in database
    $stmt = $db->prepare($sSQL);    
    $stmt->bindParam(':name', $name, PDO::PARAM_STR); 
    $stmt->bindParam(':classroom', $classroom, PDO::PARAM_STR); 
    $stmt->bindParam(':username', $username, PDO::PARAM_STR); 
    $stmt->bindParam(':password', $password, PDO::PARAM_STR); 
    $stmt->execute();
	 
}

function GetPupils($ClassNum) {

    $db = new PDO($connstr);
 
	$sSQL = "select *	
			from pupils 
			where Class = :class"; 
    // Print all pupils in database
    $stmt = $db->prepare($sSQL);    
    $stmt->bindParam(':class', $ClassNum, PDO::PARAM_INT); 
    $stmt->execute();
    $i = 1;
    echo "Starting:";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $name      = $row['Name']; 
    	echo $name . "<br>";
    }
}

function AddActual($PupilID, $Date, $Attendance, $Circumstances) {
    $pupilid      	= $_PAST["PupilID"];
    $date			= $_PAST["Date"];
    $attendance  	= $_PAST["Attendance"];
    $circumstances  = $_PAST["Circumstances"];

    $db = new PDO($connstr);
 
	$sSQL = "select *	
	 		from actual 
			where PupilID = :pupilid
			  and Date = :date"; 
    // Print all pupils in database
    $stmt = $db->prepare($sSQL);    
    $stmt->bindParam(':pupilid', $pupilid, PDO::PARAM_STR); 
    $stmt->bindParam(':date', $date, PDO::PARAM_INT); 
    $stmt->execute();

    if ($row = $stmt->fetchall(PDO::FETCH_ASSOC))
    {
		$sSQL = "update actual 
				 set Attendance = :attendance, Circumstances = :circumstances
				 where PupilID = :pupilid 
				   and Date = :date "; 
    	// Print all pupils in database
    	$stmt = $db->prepare($sSQL);    
    	$stmt->bindParam(':attendance', $attendance, PDO::PARAM_INT); 
    	$stmt->bindParam(':circumstances', $circumstances, PDO::PARAM_INT);  
    	$stmt->bindParam(':pupilid', $pupilid, PDO::PARAM_INT); 
    	$stmt->bindParam(':date', $date, PDO::PARAM_INT); 
 	    $stmt->execute();
	} else {
		$sSQL = "insert into actual 
				 (PupilID, Date, Attendance, Circumstances) 
				 VALUES (:pupilid, :date, :attendance, :circumstances)"; 
    	// Print all pupils in database
    	$stmt = $db->prepare($sSQL);    
    	$stmt->bindParam(':pupilid', $pupilid, PDO::PARAM_INT); 
    	$stmt->bindParam(':date', $date, PDO::PARAM_INT); 
    	$stmt->bindParam(':attendance', $attendance, PDO::PARAM_INT); 
    	$stmt->bindParam(':circumstances', $circumstances, PDO::PARAM_INT);  
 	    $stmt->execute();
}

GetPupils(1);
?>