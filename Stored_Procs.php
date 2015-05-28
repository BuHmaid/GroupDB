
<?php

$page_title = 'Edit User';

include 'header.html';
?>

<script src="htmlDatePicker.js" type="text/javascript"></script>

<?php
echo '<h1>Employee Payrise</h1>';
      
include "mysqli_connect.php";

//common database error handling routine
function handleDBError($dbc, $q){
    echo '<p class="error"> Error occured</p>'; 
    echo '<p>' . mysqli_error($dbc). '</p>';
    echo '<p>' . $q . '</p>';
};


if (isset($_POST['submitted'])) {
    $db = new Database();
    $dbc = $db->getConnection();

    if (isset($_POST['runpayproc'])) {
        /*         * ** TO DO **** */
        /*         * ***** call the procedure and display the values returned from the stored procedure *** */
        
        $qProcedure = 'call GivePayRise(@msg,@quantity)';
        $rProcedure = mysqli_query($dbc, $qProcedure);
        if($rProcedure){
            $qProcedure2 ='SELECT @msg AS msg, @quantity AS quantity';
            $rProcedure2 = mysqli_query($dbc, $qProcedure2);
            
            $row = mysqli_fetch_array($rProcedure2);
            echo $row['msg'];
            echo '<br<There were '.$row['quantity'].' pay rise given<br>';
        }
            
        
        
        /*         * ** End TO DO*********** */

        //display the audit table     
        $q = "select * from UserAudit";

        $r = mysqli_query($dbc, $q);

        if (!$r)
            handleDBError($dbc, $q);
        else { //display the results
            echo '<br/>';
            //display a table of results
            echo '<table align="center" cellspacing = "2" cellpadding = "4" width="75%">';
            echo '<tr bgcolor="#87CEEB"><td>
                           <b>Date</b></td><td><b>Change Details</b></td><td><b>User</b></td>
                          </tr>';
//above is the header, loop below adds the audit details    
            // $bg = '#158708';

            while ($row = mysqli_fetch_array($r)) {
                $bg = ($bg == '#158708' ? '#03193D' : '#158708');

                echo '<tr bgcolor="' . $bg . '">
                               <td>' . $row[1] . '</td><td>' . $row[3] . '</td><td>' . $row[2] . '</td>
                             </tr>';
            }
            echo '</table>';
        }
    }

    // end if submitted conditional
}
//always show form
{
    
    echo '<form action="Stored_Procs.php" method="post">
        <br />
        <h3>Call the Payrise Procedure</h3>
        <p>
        <input type="submit" class="groovybutton" name="runpayproc" value="update pay" />
        </p>
        <input type ="hidden" name="submitted" value="TRUE">
         </form>';   
}

include 'footer.html';
?>
