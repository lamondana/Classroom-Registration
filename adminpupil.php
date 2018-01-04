<?php
session_start();
include 'includes/header1.php'; // includes header
    
$db = new PDO('mysql:host=localhost;dbname=iotops27_anaproject;charset=utf8', 'iotops27_sk', 'flunjstics43,21');
$msg1 = "";
$msg2 = "";
$isActive ="";
$msg1 = "";
$msg2 = "";
$TheList = "";

$a_firstname = "";
$a_lastname = "";
$a_classroom = "";
// creating a a session index for the pupil id
$SESS_PupilID = "PupilID";
// for update the days pupil, we clear the value per day , five days, four options per day
for ($i=1; $i<=5; $i++) {
    $b_updatedays[$i][1] = "";
    $b_updatedays[$i][2] = "";
    $b_updatedays[$i][3] = "";
    $b_updatedays[$i][4] = "";
}

//Add a new pupil php
if(isset($_POST['newPupilSubmitForm'])){//Do validation
    $form_is_submitted = true;
    //validation for the  childname
    if(isset($_POST['lastname'])){
        $fullname = trim($_POST['lastname']);
            //if the imput for fullmane is not empty
        if(!empty($fullname)){            
            echo "test4";
            $firstname = $_POST["firstname"];
            $lastname  = $_POST["lastname"];
            $class     = $_POST["classroom"];
            $monday    = $_POST["monday"];
            $tuesday   = $_POST["tuesday"];
            $wednesday = $_POST["wednesday"];
            $thursday  = $_POST["thursday"];
            $friday    = $_POST["friday"];
            
            $sSQL = "insert into pupils 
                     (Firstname, Lastname, Classroom, Monday, Tuesday, Wednesday, Thursday, Friday) 
                     VALUES (:p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8)"; 
            // Print all pupils in database
            $stmt = $db->prepare($sSQL);    
            $stmt->bindParam(':p1', $firstname, PDO::PARAM_STR); 
            $stmt->bindParam(':p2', $lastname, PDO::PARAM_STR); 
            $stmt->bindParam(':p3', $class, PDO::PARAM_INT); 
            $stmt->bindParam(':p4', $monday, PDO::PARAM_INT); 
            $stmt->bindParam(':p5', $tuesday, PDO::PARAM_INT); 
            $stmt->bindParam(':p6', $wednesday, PDO::PARAM_INT); 
            $stmt->bindParam(':p7', $thursday, PDO::PARAM_INT); 
            $stmt->bindParam(':p8', $friday, PDO::PARAM_INT); 

            $stmt->execute();

            // Using the db handle, not the statement handle, this gets the latest primary key value in the  database.
            $pupilid = $db->lastInsertId();

            $target_file = "pupilpics/" . $pupilid . ".jpg";
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            }
            $msg2 = "New pupil added";
        }            
    }
}

//retrieve pupils per classroom
if(isset($_POST['class1button'])){
    DoClassroom(1);
}

//retrieve pupils per classroom
if(isset($_POST['class2button'])){
    DoClassroom(2);
}

function DoClassroom($classroom) {
    
    global $db;
    global $TheList;
    
    $form_is_submitted = true;
    $sSQL = "select * from pupils 
             where Classroom = :class
            "; 
    // Print all pupils in database
    $stmt = $db->prepare($sSQL);    
    $stmt->bindParam(':class', $classroom, PDO::PARAM_INT); 
    $stmt->execute();
    
    $TheList = "";
    // this loops through the resulting list of the SQL
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pupilid = $row['PupilID'];
        $firstname = $row['Firstname'];
        $lastname = $row['Lastname'];
        $classroom = $row['Classroom'];
        //$monday = $row['Monday'];
        //$tuesday = $row['Tuesday'];
        
        $TheList = $TheList  . "<a href='http://iotops.net/anaproject/adminpupil.php?pupilid=" . $pupilid . "'>" .
              $firstname . " " . $lastname . "</a><br>";
        
    }
    
    //echo $TheList;
}

//getting the pupil data to update it after clicking on the pupil link
//the data will appear in an update form ready to be updated
if (isset($_GET['pupilid'])) {    
    $thepupilid = $_GET['pupilid'];
   //if there is pupil id get his/her data and stick it into the form to be updated
    $sSQL = "select * from pupils where PupilID=:p1";
    $stmt = $db->prepare($sSQL);    
    $stmt->bindParam(':p1', $thepupilid, PDO::PARAM_INT); 
 
    $stmt->execute();
   
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       
        $a_firstname = $row["Firstname"];
        $a_lastname = $row["Lastname"];
        $a_classroom = $row["Classroom"];
        $a_monday = $row["Monday"];
        $a_tuesday = $row["Tuesday"];
        $a_wednesday = $row["Wednesday"];
        $a_thursday = $row["Thursday"];
        $a_friday = $row["Friday"];
        $a_active = $row["isActive"];
        
        $b_updatedays[1][$a_monday] = "selected";
        $b_updatedays[2][$a_tuesday] = "selected";
        $b_updatedays[3][$a_wednesday] = "selected";
        $b_updatedays[4][$a_thursday] = "selected";
        $b_updatedays[5][$a_friday] = "selected";
        
        $isActive = "";
        if ($a_active == 0) {
            $isActive = "checked";
        }
        
        $_SESSION[$SESS_PupilID] = $thepupilid;
    }
}

//Update a pupil php
if(isset($_POST['updatepupil'])){//Do validation
   
    $form_is_submitted = true;
    //validation for the  childname
    if(isset($_POST['lastname'])){
        
        $fullname = trim($_POST['lastname']);
            //if the imput for fullmane is not empty
        if(!empty($fullname)){            
            $firstname = $_POST["firstname"];
            $lastname  = $_POST["lastname"];
            $class     = $_POST["classroom"];
            $monday    = $_POST["monday"];
            $tuesday   = $_POST["tuesday"];
            $wednesday = $_POST["wednesday"];
            $thursday  = $_POST["thursday"];
            $friday    = $_POST["friday"];
            if (isset($_POST["active"])) {
                $active    = 0;
            } else {
                $active    = 1;
            }
            
            //var_dump($_POST);
            $pupilid = $_SESSION[$SESS_PupilID];
            
            $sSQL = "update pupils 
                     set Firstname=:firstname,
                         Lastname=:lastname, 
                         Classroom=:classroom, 
                         Monday=:monday, 
                         Tuesday=:tuesday, 
                         Wednesday=:wednesday,
                         Thursday=:thursday, 
                         Friday=:friday,
                         isActive=:active
                      where PupilID = :pupilid";
            
            $stmt = $db->prepare($sSQL);    
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR); 
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR); 
            $stmt->bindParam(':classroom', $class, PDO::PARAM_INT); 
            $stmt->bindParam(':monday', $monday, PDO::PARAM_INT); 
            $stmt->bindParam(':tuesday', $tuesday, PDO::PARAM_INT); 
            $stmt->bindParam(':wednesday', $wednesday, PDO::PARAM_INT); 
            $stmt->bindParam(':thursday', $thursday, PDO::PARAM_INT); 
            $stmt->bindParam(':friday', $friday, PDO::PARAM_INT); 
            $stmt->bindParam(':active', $active, PDO::PARAM_INT); 
            $stmt->bindParam(':pupilid', $pupilid, PDO::PARAM_INT); 
            $stmt->execute();

            $target_file = "pupilpics/" . $pupilid . ".jpg";
            if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {

            }
            
            $msg2 = "Pupil updated";
            
            
        }            
    }
}


?>
        

     <main  id ="content">
          <div>
        <nav id="commonLinks" role="navigation">
            
                    <a href="menu.php"  id="menubutton" class="round-button">Home</a>
                    <a href="login.php"  id="logoutbutton" class="round-button">Log out</a>
                
           
        </nav>
    <img id="logo" src="images/TimeFirstLogo.png" alt="logo" width="177" height="106">
        
    </div>
    
        
    
        <div id="date"><?php
echo "Today is " .date("l")."  " .date("d/m/Y") . "<br>";?>
         </div>
        <div id="errorcredentials"> <?php echo $msg1 ?>  <?php echo $msg2 ?></div>
            
             <!--Form to register a new pupil -->
          
            <form id='registerNewChild' action='adminpupil.php' method='post'  enctype="multipart/form-data" accept-charset='UTF-8'>
                <fieldset>
                    <legend>Register new child</legend>

                    <div class='inputForm'>
                        <label for='firstname'>Name*: </label>
                        <input type='text' name='firstname' id='firstname' />
                    </div>
                    <div class='inputForm'>
                        <label for='lastname'>Surname*: </label>
                        <input type='text' name='lastname' id='lastname'  />
                    </div>
                    <div class='inputForm'>
                        <label for='classroom'>Classroom:</label>
                        <input type='text' name='classroom' id='classroom' />
                    </div>
                    
                    Week attendance:<br>
                    <div class='inputForm' >
                        <label >Monday
                            <select name= "monday">
                                <option value="1">AM</option>
                                <option value="2">PM</option>
                                <option value="3">FD</option>
                                <option value="4">NA</option>
                                
                            </select>
                        </label>
                    </div>
                    <div class='inputForm' >
                        <label >Tuesday
                            <select name="tuesday">
                                <option value="1">AM</option>
                                <option value="2">PM</option>
                                <option value="3">FD</option>
                                <option value="4">NA</option>
                            </select>
                        </label>
                    </div>
                    <div class='inputForm' >
                        <label >Wednesday
                            <select name="wednesday">
                                <option value="1">AM</option>
                                <option value="2">PM</option>
                                <option value="3">FD</option>
                                <option value="4">NA</option>
                            </select>
                        </label>
                    </div>
                    <div class='inputForm' >
                        <label >Thursday
                            <select name="thursday">
                                <option value="1">AM</option>
                                <option value="2">PM</option>
                                <option value="3">FD</option>
                                <option value="4">NA</option>
                            </select>
                        </label>
                    </div>
                    <div class='inputForm' >
                        <label >Friday
                            <select name="friday">
                                <option value="1">AM</option>
                                <option value="2">PM</option>
                                <option value="3">FD</option>
                                <option value="4">NA</option>
                            </select>
                        </label>
                    </div>
                    <input type='submit' name='newPupilSubmitForm' class="miniroudbutton"value='Submit' />
                    <?php echo $msg2 ?>
                    
                </fieldset>
                <div class='inputForm'>
                        
                            <label>Select image to upload:</label>
                            <input type="file" name="fileToUpload" >
                                               
                    </div>
            </form>
         
        
        
            <!--pupil update form-->
        
       
           
             <form id='updatepupil' action='adminpupil.php' method='post' accept-charset='UTF-8'>
                <fieldset>
                    <legend>Update a pupil</legend>

                    <div class='inputForm'>
                        <label for="firstname">Name*: </label>
                        <input type='text' name='firstname' id='firstname' value="<?php echo $a_firstname ?>" />
                    </div>
                    <div class='inputForm'>
                        <label for='lastname'>Surname*: </label>
                        <input type='text' name='lastname' id='lastname' value="<?php echo $a_lastname ?> " />
                    </div>
                    <div class='inputForm'>
                        <label for='classroom'>Classroom:</label>
                        <input type='text' name='classroom' value='<?php echo $a_classroom ?>' id='classroom' />
                    </div>
                    
                    <div class='inputForm'>
                        Week attendance:<br>
                         <div class='inputForm' >
                        <label >Monday
                            <select name= "monday">
                        
                                <option value="1" <?php echo $b_updatedays[1][1]?>>AM</option>
                                <option value="2" <?php echo $b_updatedays[1][2]?>>PM</option>
                                <option value="3" <?php echo $b_updatedays[1][3]?>>FD</option>
                                <option value="4" <?php echo $b_updatedays[1][4]?>>NA</option>                                
                                
                            </select>
                        </label>
                        </div>
                        
                             <div class='inputForm' >
                        <label >Tuesday
                            <select name="tuesday">
                                <option value="1" <?php echo $b_updatedays[2][1]?>>AM</option>
                                <option value="2" <?php echo $b_updatedays[2][2]?>>PM</option>
                                <option value="3" <?php echo $b_updatedays[2][3]?>>FD</option>
                                <option value="4" <?php echo $b_updatedays[2][4]?>>NA</option>                                
                            </select>
                        </label>
                        </div>
                        <div class='inputForm' >
                        <label> Wednesday
                            <select name="wednesday">
                                <option value="1" <?php echo $b_updatedays[3][1]?>>AM</option>
                                <option value="2" <?php echo $b_updatedays[3][2]?>>PM</option>
                                <option value="3" <?php echo $b_updatedays[3][3]?>>FD</option>
                                <option value="4" <?php echo $b_updatedays[3][4]?>>NA</option>                                
                            </select>
                        </label>
                        </div>
                         <div class='inputForm' >
                        <label >Thursday
                            <select name="thursday">
                                <option value="1" <?php echo $b_updatedays[4][1]?>>AM</option>
                                <option value="2" <?php echo $b_updatedays[4][2]?>>PM</option>
                                <option value="3" <?php echo $b_updatedays[4][3]?>>FD</option>
                                <option value="4" <?php echo $b_updatedays[4][4]?>>NA</option>                                
                            </select>
                        </label>
                        </div>
                         <div class='inputForm' >
                        <label >Friday
                            <select name="friday">
                                <option value="1" <?php echo $b_updatedays[5][1]?>>AM</option>
                                <option value="2" <?php echo $b_updatedays[5][2]?>>PM</option>
                                <option value="3" <?php echo $b_updatedays[5][3]?>>FD</option>
                                <option value="4" <?php echo $b_updatedays[5][4]?>>NA</option>                                
                            </select>
                        </label>
                        </div>
                         <div class='inputForm' >
                        
                        <input type="checkbox" name="active" value="active" <?php echo $isActive ?>>Active Pupil<br>
                           
                        
                        </div>
                    </div>
                    <input type='submit'  class="miniroudbutton" name='updatepupil' value='Submit' />
                    <?php echo $msg2 ?>
                </fieldset>
                 <div class='inputForm'>
                        
                            <label>Select image to upload:</label>
                            <input type="file" name="fileToUpload2" >
                                               
                    </div>
            </form>
         
        
         
         <!--Classrooms pupil access buttons -->
          
            
            <form id='listPupils' action='adminpupil.php' method='post' accept-charset='UTF-8'>
                <button type="submit" class="round-button" name='class1button' >Classroom 1</button>
           
                
                <button type="submit" class="round-button" name='class2button' >Classroom 2</button>
               <div class= "activeusers"> <?php  echo $TheList ?></div>
            </form> 
           
   <?php
include 'includes/footer.php';
?>
