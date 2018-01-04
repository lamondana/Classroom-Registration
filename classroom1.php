<?php
    session_start();
	include 'includes/header1.php'; // includes header


    $db = new PDO('mysql:host=localhost;dbname=iotops27_anaproject;charset=utf8', 'iotops27_sk', 'flunjstics43,21');

    //print_r($_POST);

    if(isset($_POST['submitbutton'])){//Do validation
        $pupilidarray = $_SESSION["PupilArray"];
        $actualidarray = $_SESSION["ActualArray"];

        $arrlength = count($pupilidarray);
        //echo "ArrayLength:". $arrlength;
        
        // For every pupil on the gallery, get their results that the user has
        // types in, and put it into the database.
        for ($i=0; $i < $arrlength; $i++) {
            //echo "Loop:". $i;
            $pupilid = $pupilidarray[$i];
            $actualid = IntVal($actualidarray[$i]);
            
            $ddA = "A".$pupilid;
            //echo "ddA:".$ddA;
            $attend = $_POST[$ddA];
            $circumstances = $_POST["B".$pupilid];
            
            // if there is already an actual record for that pupil/day, 
            // then update it, otherwise insert a new one.

            //echo "attend:". $attend . ">";
            if ($actualid > 0) {
                $sSQL = " update actual set pupilid=:pid, attendance=:att, circumstances=:circ 
                            where actualid = :acc";
                $stmt = $db->prepare($sSQL);    
                $stmt->bindParam(':pid', $pupilid, PDO::PARAM_INT); 
                $stmt->bindParam(':att', $attend, PDO::PARAM_STR); 
                $stmt->bindParam(':circ', $circumstances, PDO::PARAM_STR); 
                $stmt->bindParam(':acc', $actualid, PDO::PARAM_INT); 
                $stmt->execute();            
            } else {
                $sSQL = " insert into actual (PupilID, Date, Attendance, Circumstances) VALUES 
                            (:pid, now(), :att, :circ)";                            
                $stmt = $db->prepare($sSQL);    
                $stmt->bindParam(':pid', $pupilid, PDO::PARAM_INT); 
                $stmt->bindParam(':att', $attend, PDO::PARAM_INT); 
                $stmt->bindParam(':circ', $circumstances, PDO::PARAM_STR); 
                $stmt->execute();            
            }
            
        }
    }


    if (isset($_GET["classroom"])) {
        $Classroom = $_GET["classroom"];
        $_SESSION["classroom"] = $Classroom;
    } else {
        $Classroom = $_SESSION["classroom"];
    }

    $sSQL = "select p.*, a.ActualID, a.Attendance, a.Circumstances
            from pupils p left join actual a on p.pupilid = a.pupilid and Date(a.Date) = CurDate()
            where p.classroom = :class ";

    $stmt = $db->prepare($sSQL);    
    $stmt->bindParam(':class', $Classroom, PDO::PARAM_INT); 
    $stmt->execute();
    
?>
        
        
        <main  id ="content">
          <div>
        <nav id="commonLinks" role="navigation">
            <ul>
                <li>
                    <a href="menu.php">Home</a>
                </li>
                <li>
                    <a href="login.php">Log out</a>
                </li>
            </ul>
        </nav>
    <img id="logo" src="images/TimeFirstLogo.png" alt="logo" width="177" height="106">
        
    </div>
    
        
    
        <div id="date"><?php
echo "Today is " .date("l")."  " .date("d/m/Y") . "<br>";?>
            <h1>Classroom 1</h1>

        <!--Classroom gallery-->
        <form id="classroom1" action="classroom1.php" method="post">
            
        <?
            $counter = 0;
            $actualidarray = array();
            $pupilidarray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {   
                $pupilid = $row["PupilID"];
                $pupilidarray[$counter] = $pupilid;
                $actualidarray[$counter] = $row["ActualID"];
                $name    = $row["fistname"] . " " . $row["lastname"];
                $imageurl = "pupilpics/" . $pupilid . ".jpg";
                if (!file_exists($imageurl)) {
                    $imageurl = "pupilpics/default.jpg";
                }
                $ddA = "A" . $pupilid;
                $ddB = "B" . $pupilid;            
                $counter += 1; 
                
        ?>
        <!-- Start of pupil -->  
        <div class="pupilGallery">
            <div class = "photobox">
                 <img src="<?php echo $imageurl?>" width="200" height="200">
            </div>
            <div class="pupilname"><?php echo $name?></div>
            <div class="pupilOptions2">
                <select name="<? echo $ddA ?>">
                    <option value="Absent" <?php if ($row["Attendance"] == 'Absent') echo ' selected="selected"'; ?>>Absent</option>
                    <option value="In School" <?php if ($row["Attendance"] == 'In School') echo ' selected="selected"'; ?>>In School</option>            
                </select>
            </div>
            <div class="pupilOptions1">
                <select name="<? echo $ddB ?>">
                    <option value="Late" <?php if ($row["Circumstances"] == 'Late') echo ' selected="selected"'; ?>>Late</option>
                    <option value="Ill" <?php if ($row["Circumstances"] == 'Ill') echo ' selected="selected"'; ?>>Ill</option>
                    <option value="Autorized absence" <?php if ($row["Circumstances"] == 'Autorized absence') echo ' selected="selected"'; ?>>Autorized absence</option>
                    <option value="School trip" <?php if ($row["Circumstances"] == 'School trip') echo ' selected="selected"'; ?>>School trip</option>
                    <option value="Left Early" <?php if ($row["Circumstances"] == 'Left Early') echo ' selected="selected"'; ?>>Left early</option>
                </select>
            </div>
            
        
        </div>
        <?php } 
            $_SESSION["PupilArray"] = $pupilidarray;
            $_SESSION["ActualArray"] = $actualidarray;
            
        ?>
        <!-- End of pupil -->  

            <div>
            <input name="submitbutton"  id= "submitbutton" type="submit" value="Submit" >
           </div>
        </form>
       </div>

    </main>

</body>

</html>
