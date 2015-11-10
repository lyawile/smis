<?php
$host = "localhost";
$user = "root";
$database = "mtiss_db";
$password = "";
//$host = "mysql17.000webhost.com";
//$user = "a1527694_smis";
//$database = "a1527694_smis";
//$password = "0404test";
$link = mysqli_connect($host, $user, $password, $database);
if(!$link){
echo "connection to database is unsuccessful ";
}
