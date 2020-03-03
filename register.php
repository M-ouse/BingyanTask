<?php
	require_once 'php_function/db_con.php';
	if(isset($_POST["email"]) && isset($_POST["passwd"]))
	{
		$uemail = $_POST["email"];
		$upw = $_POST["passwd"];
		$upw = md5($upw);
		$ugroup = 2;

		$sql_user_exists = "SELECT * FROM users WHERE uemail = '$uemail'"; 
		$result_user_exists = $conn->query($sql_user_exists);
			
		if ($result_user_exists->num_rows != 0){
			echo '<script>
				alert("Username already existed! Record doesn\'t saved");
			</script>';
		}
		else{
			$sql_new_user = 'INSERT INTO users (uemail,uname,ugroup,upw,ufirst_login)
							VALUES
							("'.$uemail.'","'.$uname.'","'.$ugroup.'","'.$upw.'","1");';
			$conn->query($sql_new_user);
			
			echo "<script>alert('Record Added');location.assign('mst_lst_user.php".$qr_string."');</script>";	
		}
	}
	/*
	if(isset($_GET["email"]) && isset($_GET["passwd"]))
	{
		$uemail = $_GET["email"];
		$upw = $_GET["passwd"];
		$upw = md5($upw);
		$ugroup = 2;

		$sql_user_exists = "SELECT * FROM users WHERE uemail = '$uemail'"; 
		$result_user_exists = $conn->query($sql_user_exists);
			
		if ($result_user_exists->num_rows != 0){
			echo '<script>
				alert("Username already existed! Record doesn\'t saved");
			</script>';
		}
		else{
			$sql_new_user = 'INSERT INTO users (uemail,uname,ugroup,upw,ufirst_login)
							VALUES
							("'.$uemail.'","'.$uname.'","'.$ugroup.'","'.$upw.'","1");';
			$conn->query($sql_new_user);
			
			echo "<script>alert('Record Added');location.assign('mst_lst_user.php".$qr_string."');</script>";	
		}
	}*/
?>