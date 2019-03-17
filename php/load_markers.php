<?php
$servername = "localhost";
$username = "dispose_access";
$database = "dispose";

$doc = domxml_new_doc("1.0");
$node = $doc->create_element("markers");
$parnode = $doc->append_child($node);

$connection=mysql_connect ($servername, $username);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$query = "SELECT * FROM markers WHERE 1";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

while ($row = @mysql_fetch_assoc($result)){
    // Add to XML document node
    $node = $doc->create_element("marker");
    $newnode = $parnode->append_child($node);
  
    $newnode->set_attribute("id", $row['id']);
    $newnode->set_attribute("name", $row['name']);
    $newnode->set_attribute("address", $row['address']);
    $newnode->set_attribute("lat", $row['lat']);
    $newnode->set_attribute("lng", $row['lng']);
    $newnode->set_attribute("type", $row['type']);
    $newnode->set_attribute("status", $row['type']);
  }
  
  $xmlfile = $doc->dump_mem();
  echo $xmlfile;

?>