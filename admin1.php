<?php
session_start();

include 'includes/header1.php'; // includes header
//display all php errors on the browser
//ini_set('display_errors', '1'); 	
//include 'includes/header.php'; // includes header

//database connection for debugging purposes
$db = new PDO('mysql:host=localhost;dbname=iotops27_anaproject;charset=utf8', 'iotops27_sk', 'flunjstics43,21');
// Add User

$msg1 = "";
$msg2 = "";

$SESS_UserID = "UserID";


if(isset($_POST['newUserSubmitForm'])){//Do validation
    $form_is_submitted = true;
   
    
    if(isset($_POST['lastname'])){
        $fullname = trim($_POST['lastname']);
            //if the imput for fullmane is not empty
        
        if(!empty($fullname)){
            
           
		    $firstname	= $_POST['firstname'];
		    $lastname 	= $_POST['lastname'];
		    $classroom	= $_POST['classroom'];
		    $username	= $_POST['username'];
		    $password	= $_POST['password'];
    
            $sSQL = "select * from users where Username=:p1";
		    $stmt = $db->prepare($sSQL);    
		    $stmt->bindParam(':p1', $username, PDO::PARAM_STR); 
		    $stmt->execute();
  	        if ($row = $stmt->fetchall(PDO::FETCH_ASSOC)) {
                $msg1 = "The Username has already been used";                
            } else {            
                $sSQL = "insert into users 
                         (Firstname, Lastname, Classroom, Username, Password) 
                        VALUES (:firstname, :lastname, :classroom, :username, :password)"; 
                
                $stmt = $db->prepare($sSQL);    
                $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR); 
                $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR); 
                $stmt->bindParam(':classroom', $classroom, PDO::PARAM_STR); 
                $stmt->bindParam(':username', $username, PDO::PARAM_STR); 
                $stmt->bindParam(':password', $password, PDO::PARAM_STR); 
                $stmt->execute();
                $msg2 = "New user added";                
            }            
        }
            
    }
}

//retrieve users
if(isset($_POST['userbutton'])){
    $form_is_submitted = true;
    $sSQL = "select * from users 
            "; 
    // Print all pupils in database
    $stmt = $db->prepare($sSQL);    
    $stmt->execute();
    
    $TheList = "";
    // this loops through the resulting list of the SQL
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $userid = $row['UserID'];
        $firstname = $row['Firstname'];
        $lastname = $row['Lastname'];
        $classroom = $row['Classroom'];
        $username = $row['Username'];
        $password = $row['Password'];
        
        $TheList = $TheList  . "<a href='http://iotops.net/anaproject/admin1.php?userid= " . $userid . "'>" .
              $firstname . " " . $lastname . "</a><br>";
        
    }
    
    
}

//getting the users data to update it after clicking on the user link
//the data will appear in an update form ready to be updated
if (isset($_GET['userid'])) {    
    $theuserid = $_GET['userid'];
   //if there is user id get his/her data and stick it into the form to be updated
    $sSQL = "select * from users where UserID=:p1";
    $stmt = $db->prepare($sSQL);    
    $stmt->bindParam(':p1', $theuserid, PDO::PARAM_INT); 
 
    $stmt->execute();
   
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       
        //var_dump($row);
        $a_firstname = $row["Firstname"];
        $a_lastname = $row["Lastname"];
        $a_classroom = $row["Classroom"];
        $a_username = $row["Username"];
        $a_password = $row["Password"];
        $a_active = $row["isActive"];
        
        $isActive = "";
        if ($a_active == 0) {
            $isActive = "checked";
        }
        
        $_SESSION[$SESS_UserID] = $theuserid;
       // var_dump($_SESSION);
    }
}

if(isset($_POST['updateuserSubmit'])){//Do validation
    $form_is_submitted = true;
   
    if(isset($_POST['lastname'])){
        $fullname = trim($_POST['lastname']);
            //if the imput for fullmane is not empty
        if(!empty($fullname)){
            
		    $firstname	= $_POST['firstname'];
		    $lastname 	= $_POST['lastname'];
		    $classroom	= $_POST['classroom'];
		    $username	= $_POST['username'];
		    $password	= $_POST['password'];
		    $active   	= $_POST['active'];
    
            $theuserid = $_SESSION[$SESS_UserID];

            $sSQL = "update users 
                     set Firstname=:firstname, 
                         Lastname=:lastname, 
                         Classroom=:classroom, 
                         Username=:username, 
                         Password=:password,
                         isActive=:active
                      where UserID = :userid";

            $stmt = $db->prepare($sSQL);    
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR); 
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR); 
            $stmt->bindParam(':classroom', $classroom, PDO::PARAM_STR); 
            $stmt->bindParam(':username', $username, PDO::PARAM_STR); 
            $stmt->bindParam(':password', $password, PDO::PARAM_STR); 
            $stmt->bindParam(':active', $active, PDO::PARAM_INT); 
            $stmt->bindParam(':userid', $theuserid, PDO::PARAM_INT); 
            $stmt->execute();
            $msg1 = "User updated";                
        }
            
    }
}




if(isset($_POST['ReportDateSubmitForm'])){
    $form_is_submitted = true;
   
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
    
        
    
        <div id="date">
            <?php
echo "Today is " .date("l")."  " .date("d/m/Y") . "<br>";?>
        </div>
        
        <div id="errorcredentials"> <?php echo $msg1 ?>  <?php echo $msg2 ?></div>
        
            <!--Form to register a new pupil -->
           <div class= forms> 
            <form id='registerNewUser' action='admin1.php' method='post' accept-charset='UTF-8'>
                <fieldset>

                    <legend>Register new user</legend>
                    <div class='inputForm'>
                        <label for='name'>Name*: </label>
                        <input type='text' name='firstname' id='name' maxlength="50" />
                    </div>
                    <div class='inputForm'>
                        <label for='name'>Surname*: </label>
                        <input type='text' name='lastname' id='lastname' maxlength="50" />
                    </div>
                    <div class='inputForm'>
                        <label for='username'>UserName*:</label>
                        <input type='text' name='username' id='username' maxlength="50" />
                    </div>
                    <div class='inputForm'>
                        <label for='password'>Password*:</label>
                        <input type='password' name='password' id='password' maxlength="50" />
                    </div>
                    <div class='inputForm'>
                        <label for='classroom'>Classroom: </label>
                        <select name="classroom">
                            <option value="1">Classroom 1</option>
                            <option value="2">Classroom 2</option>
                        </select>
                    </div>
                    <div class='inputForm'>
                        <input type='submit'  class="miniroudbutton" name='newUserSubmitForm' value='Submit' />
                    </div>
                   
                </fieldset>
            </form>
        </div>
        
       
        
        <!--Formto update the users-->
        <div class="forms">
            <form id='updateuser' action='admin1.php' method='post' accept-charset='UTF-8'>
                <fieldset>

                    <legend>Update user</legend>
                    <div class='inputForm'>
                        <label for='name'>Name*: </label>
                        <input type='text' name='firstname' id='name' maxlength="50" value="<?php echo $a_firstname ?>" />
                    </div>
                    <div class='inputForm'>
                        <label for='name'>Surname*: </label>
                        <input type='text' name='lastname' id='lastname' maxlength="50" value="<?php echo $a_lastname ?>" />
                    </div>
                    <div class='inputForm'>
                        <label for='username'>UserName*:</label>
                        <input type='text' name='username' id='username' maxlength="50" value="<?php echo $a_username ?>" />
                    </div>
                    <div class='inputForm'>
                        <label for='password'>Password*:</label>
                        <input type='text' name='password' id='password' maxlength="50" value="<?php echo $a_password ?>"/>
                    </div>
                    <div class='inputForm'>
                        <label for='classroom'>Classroom: </label>
                        <select name="classroom">
                            <option value="1">Classroom 1</option>
                            <option value="2">Classroom 2</option>
                        </select>
                    </div>
                    <div class='inputForm'>
                        <input type='submit' name='updateuserSubmit' class="miniroudbutton" value='Submit' />
                    </div>
                   
                </fieldset>
            </form>
            
        </div>
            
            <form id='listusers' action='admin1.php#listusers' method='post' accept-charset='UTF-8'>
                <button type="submit" class="round-button" name='userbutton'>Users</button>
                 <div class= "activeusers"> <?php   echo  $TheList ?></div>
            </form>
        
       


 <?php
include 'includes/footer.php';
?>
