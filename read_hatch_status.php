<?php
ini_set('display_errors', '1');

//----------database access----------------------------
include_once 'util.php'; // Ensure this file exists and is correctly configured
//-----------------------------------------------------

try {
    // Create the database connection
    $con = create_db_connection();

    // Query to get the latest entry in the table
    $sql = "SELECT * FROM hatch_status_log 
            JOIN hatch_position 
            ON hatch_status_log.status = hatch_position.status 
            WHERE 1 
            ORDER BY `timestamp` DESC 
            LIMIT 1";

    // Execute the query and fetch the row
    $row = db_select_row($con, $sql);

    // Close the database connection
    close_db_connection($con);

    // Extract the status value
    $status = $row['pos']; // Assumes 'pos' is a valid column in the result

    // Output the status as plain text
    echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8');
} catch (Exception $e) {
    // Handle any exceptions and output an error message
    echo "Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
?>
