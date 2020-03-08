<?php
	require_once 'php_function/db_con.php';
	if(isset($_POST))
	{
		 $json = file_get_contents('php://input');
    	//加true转换为数组，不加转换为对象
    	$arr =  json_decode($json, true);
		//echo $_POST[0];
		$uemail = $arr["email"];
		$upw = $arr["passwd"];
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
			echo "<script>
					alert('Registered successfully!');
					location.assign('inedx.php');
				</script>";
		}
	}
?>