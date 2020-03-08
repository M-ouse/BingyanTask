<?php
$servername = "localhost";
$username	= "root";
$password	= "";
$db 		= "";

$conn = new mysqli($servername, $username, $password, $db);
ob_start();

if(session_status() === PHP_SESSION_NONE)
{
	session_start();
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/*else
{
	echo "Connection Successful";
}*/

?>
