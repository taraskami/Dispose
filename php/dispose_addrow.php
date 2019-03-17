<?php

$servername = "localhost";
$username = "dispose_access";
$database = "dispose";

// Gets data from URL parameters.
$name = $_GET['name'];
$address = $_GET['address'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$type = $_GET['type'];
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

$name_sql = mysqli_real_escape_string($connection, $name);
$address_sql = mysqli_real_escape_string($connection, $address);
$lat_sql = mysqli_real_escape_string($connection, $lat);
$lng_sql = mysqli_real_escape_string($connection, $lng);
$type_sql = mysqli_real_escape_string($connection, $type);
$status_sql = mysqli_real_escape_string($connection, $status);

// Inserts new row with place data.
$query = sprintf("INSERT INTO markers " .
         " (id, name, address, lat, lng, type, status) " .
         " VALUES (NULL, '$name_sql', '$address_sql', '$lat_sql', '$lng_sql', '$type_sql', '$status_sql');");

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