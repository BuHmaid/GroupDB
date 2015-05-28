<?php


  
 class Database
{
   
    public $dbc = NULL;

    public function getDBConnection() {

        //   echo('connecting to studev 2');
        if ($this->dbc == NULL)
            $this->dbc = mysqli_connect('studev2', '201101299', 'polytechnic', '201101299');

        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            die('b0ther');
        }

        return $this->dbc;
    }

    public function getConnection() {
        return $this->getDBConnection();
    }

    function __destruct() {
        //the destructor is called when there are no more references to the object
        //print "Destroying the connection<br>";
        $this->closeDB();
    }

    public function closeDB() {
        mysqli_close($this->dbc);
    }

}
?>
