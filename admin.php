<?php
include 'includes/header.php'; // includes header
//display all php errors on the browser
ini_set('display_errors', '1'); 	
//include 'includes/header.php'; // includes header

//database connection for debugging purposes
$db = new PDO('mysql:host=localhost;dbname=iotops27_anaproject;charset=utf8', 'iotops27_sk', 'flunjstics43,21');
// Add User
echo "Starting insert 1<br>";
$msg1 = "";
$msg2 = "";
if(isset($_POST['newUserSubmitForm'])){//Do validation
    $form_is_submitted = true;
   
    echo "Starting insert 2<br>";
    if(isset($_POST['lastname'])){
        $fullname = trim($_POST['lastname']);
            //if the imput for fullmane is not empty
        echo "Starting insert 3<br>";
        if(!empty($fullname)){
            
            echo "Starting insert 4<br>";
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
                // Print all pupils in database
                $stmt = $db->prepare($sSQL);    
                $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR); 
                $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR); 
                $stmt->bindParam(':classroom', $classroom, PDO::PARAM_STR); 
                $stmt->bindParam(':username', $username, PDO::PARAM_STR); 
                $stmt->bindParam(':password', $password, PDO::PARAM_STR); 
                $stmt->execute();
                $msg1 = "New user added";                
            }            
        }
            
    }
}



if(isset($_POST['ReportDateSubmitForm'])){
    $form_is_submitted = true;
    //validation for the  childname
}
//request
$sSQL = "Select * from users "; 
// asking mysql to prepare and check the request $sSQL if it works carry on if not show the error
$stmt = $db->prepare($sSQL) or die("Select Failed ".mysql_error());
//execute the sql
$stmt->execute(); 

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "id: " . $row['UserID']. " - Name: " . $row['Firstname']. " " . $row['Lastname'] . "<br>";
    //echo "Test";
}


?>
    <div id="container">
        <main id="maincontent">
            <h1>Admin</h1>

            <section class="formbox">
                <form id='registerNewUser' action='admin.php' method='post' accept-charset='UTF-8'>
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
                            <input type='submit' name='newUserSubmitForm' value='Submit' />
                        </div>
                        <?php echo $msg1 ?>
                    </fieldset>
                </form>
            </section>



            <section class="formbox">
                <form id="reportDate" action="report.php">

                    <fieldset>
                        <legend>Report date:</legend>

                        <div class="inputForm">
                            <input id="ReportDate" name="ReportDate" type=d ate>
                        </div>
                        <div class="inputForm">
                            <input type='submit' name='ReportDateSubmitForm' value='Submit'>
                        </div>

                    </fieldset>
                </form>
            </section>



       <?php
include 'includes/footer.php';
?>