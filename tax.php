<?php

include ("db.php");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
    foreach (scandir("tax/") as $file) {
        echo $file . " ";
        if ($file == '.' || $file == '..')
            continue;
// Assuming $file contains the file path
$query = 'LOAD DATA LOCAL INFILE :file_path INTO TABLE adrs.taxes FIELDS TERMINATED BY \',\' ENCLOSED BY \'\"\' LINES TERMINATED BY \'\\n\' IGNORE 1 LINES';
$stmt = $conn->prepare($query);
$stmt->bindParam(':file_path', $file);
$stmt->execute();
        
    }
?>
        