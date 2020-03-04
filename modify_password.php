<?php
	require_once 'php_function/general.php'; //general php function
	require_once 'php_function/function_report.php';
	
	/*get user information*/
	$user_name = $_SESSION["sess_uname"];
	$user_id = $_SESSION["sess_uid"];
	$user_grroup = $_SESSION["sess_ugroup"];

	//var_dump($user_name);
	/*2 level user cannnot visit this page*/
	if($user_grroup == 2)
	{
		header("Location: index.php");
	}
?>
<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <title>Document</title>

</head>

<body>

<form action="modify_password.php" method="post" name="form1">

  <table width="300" border="0" cellpadding="0"  cellspacing="0">

    <tr>

      <td height="30">New password:

 <input type="text" name="password" size="20">

        <input type="submit" name="submit" value="Submit">

      </td>

    </tr>

  </table>

</form>

</body>

</html>
<?php
	if($_POST['password'])
	{
		$passwd = md5($_POST['password']);
		$ch_passwd_sql = 'UPDATE users SET upw="'.$passwd.'" WHERE uname="'.$user_name.'";';
		//echo $ch_passwd_sql;
		$conn->query($ch_passwd_sql);
		echo "<script>
					alert('Changes Saved');
					location.assign('inv_menu.php".$qr_string."');
				</script>";	
	}
?>