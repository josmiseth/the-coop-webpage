<?php

//change the time zone as per your country
date_default_timezone_set("Europe/Oslo");

include_once 'util.php';

$val=$_GET["status"];

//$val="1";
insert_in_db($val);

function insert_in_db($val){   
   echo"<p>Inserting value <b>$val</b> in database</p>";
   
    $connection=create_db_connection();
    
    $t=time();
    $date_time= date('Y-m-d H:i:s', $t); 
    
    echo "<p>$date_time</p>";

    $sql="INSERT INTO `hatch_status_log`(`status`, `timestamp`, `date_time`)
                      VALUES ('$val','$t', '$date_time')";
   
    $result = mysqli_query($connection,$sql);
    
         if ( !$result ) {
            die(mysql_error()."\n".$sql);
            echo" !!!<br> ";
            //return 0;
         }
    
        if ( $result ) {
            echo" <p>successfully inserted >>>> </p> ";
            //return 1;
      }
 
    close_db_connection($connection);
    
}

?>

