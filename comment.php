<?php
	require_once 'php_function/general.php'; //general php function

	$uid = $_SESSION["sess_uid"];//user's id
	
	$way = "NULL";
	if($_GET['id'])
	{
		$_SESSION["did"] = $_GET['id'];
		$way = "id";
		$id = $_GET['id'];//product's id
		$get_discuss_sql = "SELECT cont,uid,date_printed FROM discuss_of_id WHERE drug_id='$id';";
		//echo $get_discuss_sql;
		$result_med_lst = $conn->query($get_discuss_sql);
		if ($result_med_lst->num_rows > 0)
		{
			while($row = $result_med_lst->fetch_assoc()){
				echo 
				"
					<tr>
						<td>"."@user ".$row["uid"] ."</td>
						<td>".date('Y-m-s h:i:s',$row["date_printed"]).':'."</td>
						<td>".$row["cont"]."</td><br>
					</tr>
				";
			}
		}
	}
	if($_GET['name'])
	{
		$_SESSION["did"] = $_GET['name'];
		$way = "name";
		$id = $_GET['name'];//product's id
		$get_discuss_sql = "SELECT cont,uid,date_printed FROM discuss WHERE drug_id='$id';";
		//echo $get_discuss_sql;
		$result_med_lst = $conn->query($get_discuss_sql);
		if ($result_med_lst->num_rows > 0)
		{
			while($row = $result_med_lst->fetch_assoc()){
				echo 
				"
					<tr>
						<td>"."@user ".$row["uid"] ."</td>
						<td>".date('Y-m-s h:i:s',$row["date_printed"]).':'."</td>
						<td>".$row["cont"]."</td><br>
					</tr>
				";
			}
		}
	}
	if($_GET['date'])
	{
		$_SESSION["did"] = $_GET['date'];
		$way = "date";
		$id = $_GET['date'];//product's id
		$get_discuss_sql = "SELECT cont,uid,date_printed FROM discuss_of_time WHERE drug_id='$id';";
		//echo $get_discuss_sql;
		$result_med_lst = $conn->query($get_discuss_sql);
		if ($result_med_lst->num_rows > 0)
		{
			while($row = $result_med_lst->fetch_assoc()){
				echo 
				"
					<tr>
						<td>"."@user ".$row["uid"] ."</td>
						<td>".date('Y-m-s h:i:s',$row["date_printed"]).':'."</td>
						<td>".$row["cont"]."</td><br>
					</tr>
				";
			}
		}
	}
	if($_GET['status'])
	{
		$_SESSION["did"] = $_GET['status'];
		$way = "status";
		$id = $_GET['status'];//product's id
		$get_discuss_sql = "SELECT cont,uid,date_printed FROM discuss_of_status WHERE drug_id='$id';";
		//echo $get_discuss_sql;
		$result_med_lst = $conn->query($get_discuss_sql);
		if ($result_med_lst->num_rows > 0)
		{
			while($row = $result_med_lst->fetch_assoc()){
				echo 
				"
					<tr>
						<td>"."@user ".$row["uid"] ."</td>
						<td>".date('Y-m-s h:i:s',$row["date_printed"]).':'."</td>
						<td>".$row["cont"]."</td><br>
					</tr>
				";
			}
		}
	}
	//$result_total_line = $conn->query($sql_total_line);
echo '
<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <title>Comment Page</title>

</head>

<body>

<form action="comment.php" method="post" name="form1">

  <table width="300" border="0" cellpadding="0"  cellspacing="0">

    <tr>

      <td height="30">Your Comment:

 <input type="text" name="comment" size="77">
 <div style="display:none;">
 <input type="text" name="'.$way.'" value="1">
</div>
        <input type="submit" name="submit" value="Submit">

      </td>

    </tr>

  </table>

</form>

</body>

</html>
'
?>
<?php
	if($_POST['comment'])
	{
		$date = time();
		$comment = $_POST['comment'];

		if($_POST['id'])
			$sql_add_comment = 'INSERT INTO discuss_of_id (cont,drug_id,uid,date_printed) VALUES ("'.$comment.'","'.$_SESSION["did"].'","'.$uid.'","'.$date.'");';
		if($_POST['name'])
			$sql_add_comment = 'INSERT INTO discuss (cont,drug_id,uid,date_printed) VALUES ("'.$comment.'","'.$_SESSION["did"].'","'.$uid.'","'.$date.'");';
		if($_POST['date']){
			$sql_add_comment = 'INSERT INTO discuss_of_time (cont,drug_id,uid,date_printed) VALUES ("'.$comment.'","'.$_SESSION["did"].'","'.$uid.'","'.$date.'");';
		}
		if($_POST['status'])
			$sql_add_comment = 'INSERT INTO discuss_of_status (cont,drug_id,uid,date_printed) VALUES ("'.$comment.'","'.$_SESSION["did"].'","'.$uid.'","'.$date.'");';
		$sql_add_comment;
		$conn->query($sql_add_comment);
		//echo $sql_add_comment; 
		//echo "yeap";
		echo "<script>alert('Send Discussion Done');</script>";
	}
?>