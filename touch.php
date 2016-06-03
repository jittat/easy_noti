<?php
$file_name = $_GET["q"];

if(!preg_match('/[a-z_]+/',$file_name)) {
  echo "Bad format";
  return;
}
if(strlen($file_name) > 20) {
  echo "Bad format";
  return;
}
if(file_exists($file_name)) {
  touch($file_name);
  echo "OK";
} else {
  echo "Not found";
}
?>
