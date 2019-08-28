<?php

    $conn = new mysqli('localhost', "r0ot3d", "RTYfGhVbN!3$", "adrs");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
    foreach (scandir("tax") as $file) {
        $query = "LOAD DATA LOCAL INFILE ('" . $file . "') INTO TABLE names FIELDS TERMINATED BY ',' ENCLOSED BY '".chr(34)."' LINES TERMINATED BY '\n' IGNORE 1 ROWS";
        if ($conn->query($query) === TRUE) { 
            // data imported
        }
    }
?>
        