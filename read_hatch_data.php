<?php
ini_set('display_errors', '1');

//----------database access----------------------------
include_once 'util.php';
//-----------------------------------------------------

$con=create_db_connection();

/* select the latest entry in the table */
//$sql="SELECT * FROM `hatch_status_log` WHERE 1 order by `timestamp` desc limit 1";

$sql="SELECT * FROM hatch_status_log JOIN hatch_position ON hatch_status_log.status = hatch_position.status WHERE 1 order by `timestamp` desc limit 1";


$row=db_select_row($con,$sql);

close_db_connection($con);

//SELECT pos FROM hatch_position WHERE status = '0'

$status=$row['pos']; //this corresponds to the last value written to the hatch status file

$style="background-color:white;color:grey";

$timestamp=$row['timestamp'];

$currentTime = time();
$diff=$currentTime-$timestamp; //how old the entry is 

if($diff>60){
   $str=time_ago($timestamp);
   $ago="Since: <txt style='color:brown'>$str</txt>";
}
else{
   $ago="";
}



$html="<div style='$style'>
			Current position: $status <br>$ago
			<hr>
		</div>
";

echo $html;
	
?>