<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'contact_form_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>