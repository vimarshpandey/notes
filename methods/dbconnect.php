<?php
    $db_server = "localhost:3307";
    $db_user = "root";
    $db_pass = "";
    $db_name = "notesdb";

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    if($conn->connect_error)
    {
        die("connection failed: " . $conn->connect_error);
    }
?>