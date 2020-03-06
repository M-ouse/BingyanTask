<?php
	require_once 'php_function/general.php'; //general php function
	
	$user_name = $_SESSION["sess_uname"];
	$user_id = $_SESSION["sess_uid"];
	$user_grroup = $_SESSION["sess_ugroup"];


	/*2 level user cannnot visit this page*/
	/*if($user_grroup == 2)
	{
		header("Location: index.php");
	}*/
	if(isset($_GET["drug_id"]) && $_GET["drug_id"] != NULL)
	{
		$id = $_GET["drug_id"];
		$email = $_GET["uemail"];
		$sql_insert_sub = "INSERT INTO subscribe (id,email) VALUES ('$id','$email');";
		$conn->query($sql_insert_sub);
		//echo $sql_insert_sub;
		echo "<script>alert('Subscribed successfully!');location.assign('inv_menu.php');</script>";		
	}
?>