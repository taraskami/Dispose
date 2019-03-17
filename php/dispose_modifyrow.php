<?php

$servername = "localhost";
$username = "dispose_access";
$database = "dispose";

// Gets data from URL parameters.
$id = $_GET['id'];
$status = $_GET['status'];

// Opens a connection to a MySQL server.
$connection = new mysqli($servername, $username);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Sets the active MySQL database.
$db_selected = mysqli_select_db( $connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error());
}


$id_sql = mysqli_real_escape_string($connection, $id);
$status_sql = mysqli_real_escape_string($connection, $status);

// Inserts new row with place data.
$query = sprintf("UPDATE markers SET " .
         " status = '$status' WHERE id = '$id';");

$result = mysqli_query($connection, $query);

if ($result){
    echo "Successful";
} else {
    echo "ERROR";
}

if (!$result) {
  die('Invalid query: ' . mysqli_error($connection));
}

?>