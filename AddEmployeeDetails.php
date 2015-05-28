<?php
ini_set('display_errors', 1);

error_reporting(E_ALL);
 
$page_title = 'Add Employee';

include 'header.html';
//this is good
?>


<?php
echo '<h1>Add Employee</h1>';
      
include "mysqli_connect.php";


function generateSelect() {
    //create an associative array of key-value pairs
    $roles = array(
    'Manager' => 1,
    'Worker' => 2,
    'Slave' => 3);

    $html = '<select name="EmpRole">';
    
    //the foreach statement takes the key/value from the array and stores them in the $role and
    //$value variables
    //the drop down list displays text and also stores a values for that text
    foreach ($roles as $role => $value) {
        $html .= '<option value='.$value.'>'.$role.'</option>';
    }
    $html .= '</select>';
    return $html;
}

 $dropdown = generateSelect();
 
    echo '<form action="AddEmployeeDetails.php" method="post">
        <br />
        <h3>Add New Employee</h3>
        <p>Employee first Name <input type="text" name="EmpFName" /></p>
        <p>Employee last name <input type="text" name="EmpLName" /></p>
        <p>Employee salary <input type="text" name="EmpSalary" /></p>
        <p>Employee Role '.$dropdown.'</p>    
        <p>Employee start date (yyyy/mm/dd): <input type="date" name="EmpStartDate" />
        <input type="submit" class="groovybutton" name="submitted" value="Add Employee" /></p>
        <input type ="hidden" name="submitted" value="TRUE">
         </form>';   


if(isset($_POST['submitted']))
{
    include 'DO_Employee.php';

    $employee = new DO_Employee();
//create a new user a populate the member variables from values on the form
    $employee->EmpFName = trim($_POST['EmpFName']);
    $employee->EmpLName = trim($_POST['EmpLName']);
    $employee->EmpStartDate = trim($_POST['EmpStartDate']);
    $employee->EmpSalary = trim($_POST['EmpSalary']);
    $employee->EmpRole = trim($_POST['EmpRole']);
    
    //print_r($employee);

    /* call this method to check if the fields contain valid data and perfrom other validation checks - if not valid the display 
     * error messages. If fields are valid, check the email and then save the user object to the database.
     * 
     * If any errors are detected the isValid method will return an array of messages which can be displayed 
     */

    $errors = $employee->isValid();
    

    if (empty($errors)) {
        
        if ($employee->save()) 
             echo "<h1> Thankyou </h1><p>$employee->EmpFName $employee->EmpLName is now added</p>";
     }
        else
    {
        //display the error messages returned from the isValid() method
        echo '<p class="error"> Error </p>';

        foreach ($errors as $msg)
            echo " - $msg<br /> ";
    }
    
 
    
} // end if submitted conditional

   
    ?>

<?php

include 'footer.html';
?>