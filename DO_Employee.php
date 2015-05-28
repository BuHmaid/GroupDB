<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DO_Employee
 *
 * @author malcolm.mckenzie
 */
include_once "mysqli_connect.php";

class DO_Employee extends Database {

    //put your code here
    public $idEmployee = null;
    public $EmpFName;
    public $EmpLName;
    public $EmpStartDate;
    public $EmpSalary;
    public $EmpRole;
    public $errorMsg;

    public function DO_Employee() {
        $this->getDBConnection();
    }

    public function get($id) {
        if ($this->getDBConnection()) {

            $q = 'SELECT * FROM Employee WHERE idEmployee=' . $id;
            $r = mysqli_query($this->dbc, $q);

            if ($r) {
                $row = mysqli_fetch_array($r);

                $this->idEmployee = $row['idEmployee'];
                $this->EmpFName = $row['EmpFName'];
                $this->EmpLName = $row['EmpLName'];
                $this->EmpStartDate = $row['EmpStartDate'];
                $this->EmpSalary = $row['EmpSalary'];
                $this->EmpRole = $row['EmpRole'];

                return true;
            } else
                $this->displayError($q);
        } else
            echo '<p class="error">Could not connect to database</p>';

        return false;
    }

    public function save() {
        if ($this->getDBConnection()) {
            //escape any special characters
            $this->EmpFName = mysqli_real_escape_string($this->dbc, $this->EmpFName);
            $this->EmpLName = mysqli_real_escape_string($this->dbc, $this->EmpLName);
            $this->EmpRole = mysqli_real_escape_string($this->dbc, $this->EmpRole);

            $q = "INSERT INTO Employee  ";

            $r = mysqli_query($this->dbc, $q);

            if (!$r) {
                $this->displayError($q);
                return false;
            }

            return true;
        } else {
            echo '<p class="error">Could not connect to database</p>';
            return false;
        }

        return true;
    }

//end of function

    public function delete() {
        if ($this->getDBConnection()) {
            $q = "DELETE FROM Employee WHERE idEmployee=" . $this->idEmployee;
            $r = mysqli_query($this->dbc, $q);

            if (!$r) {
                $this->displayError($q);
                return false;
            }
            return true;
        } else {
            echo '<p class="error">Could not connect to database</p>';
            return false;
        }
    }

    public function validateFields() {

        return $errors;
    }

    public function isValid() {
        //declare array to hold any errors messages  
        $errors = array();

        if (empty($this->EmpFName))
            $errors[] = 'First name may not be empty';

        if (empty($this->EmpLName))
            $errors[] = 'Last name may not be empty';

        if (empty($this->EmpSalary))
            $errors[] = 'Salary may not be empty';

        if (empty($this->EmpStartDate))
            $errors[] = 'Start date may not be empty';


        return $errors;
    }

    private function displayError($q) {
        echo '<p class="error">' . $q . '</p>';
        echo '<p class="error">A database error occurred</p>';
        echo '<p class="error">' . mysqli_error($this->dbc) . '</p>';
    }

}

?>