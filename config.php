<?php

$servername = 'localhost';
$username   = 'deb100851_memes';
$password   = 'kankerhoer';
$dbname     = 'deb100851_memes';

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
    echo "geen connectie";
} else {
}

session_start();

?>