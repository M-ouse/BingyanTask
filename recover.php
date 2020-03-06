<?php
	require_once 'php_function/general.php'; //general php function
	if(isset($_GET["cmdid"]))
	{
		$id= $_GET["cmdid"];
		
		$sql_query_last = "SELECT ID FROM history ORDER BY ID DESC LIMIT 1;";
		$result = $conn->query($sql_query_last);
		$last_ID = $result->fetch_assoc()["ID"];//get last obj id
		
		for ($i=$last_ID; $i>=$id; $i--) 
		{
  			$sql_que_cmd = "SELECT ID, staff, cmd, detail
							FROM history
							where ID = $i
							;";
			$result = $conn->query($sql_que_cmd)->fetch_assoc();

			$cmd = $result["cmd"];//get command
			$dump = json_decode($result["detail"]);//get array

			$obj_id = $dump[0];//get id of the object

			/*echo $cmd." ".$obj_id;
			echo "<br>";*/
			if($cmd == "CREATE")//recover create
			{
				$sql_delete_med = 'UPDATE mst_medicine SET deleted = "1" WHERE drug_id = "'.$obj_id.'";';
				$conn->query($sql_delete_med);
			}
			if($cmd == "DELETED")//recover delete
			{
				$sql_delete_med = 'UPDATE mst_medicine SET deleted = "0" WHERE drug_id = "'.$obj_id.'";';
				$conn->query($sql_delete_med);
			}
			if($cmd == "EDIT")//recover edit
			{
				$loc = $dump[1];
				$original = $dump[2];
				//$now = $dump[3];

				$sql_edit_med = 'UPDATE mst_medicine SET ';
				if($loc == "name")$sql_edit_med.="name ";
				if($loc == "model")$sql_edit_med.="model ";
				if($loc == "price")$sql_edit_med.="price ";
				if($loc == "status")$sql_edit_med.="status ";
				if($loc == "count")$sql_edit_med.="count ";
				$sql_edit_med.="= '$original' WHERE drug_id = '$obj_id'";
				//echo $sql_edit_med;
				$conn->query($sql_edit_med);
				//echo $loc." ".$original." ".$now;
			}
		}
		$sql_del_above = "DELETE FROM history where ID>='$id';";
		//echo $sql_del_above;
		$conn->query($sql_del_above);
		echo "<script>
					alert('Recover history successfully!');
					location.assign('history.php');
				</script>";
	}
?>