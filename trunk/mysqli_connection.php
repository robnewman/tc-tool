<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'ruo99jia';
$dbname = 'tctool';
is_resource(mysqli) || $mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname) or die("Program died. Cannot link to the Database.".mysqli_connect_error());
