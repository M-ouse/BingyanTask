<?php
	require_once 'php_function/general.php'; //general php function
	$user_grroup = $_SESSION["sess_ugroup"];


	/*2 level user cannnot visit this page*/
	if($user_grroup == 2)
	{
		header("Location: index.php");
	}
	if(isset($_SESSION['qr_string'])){
		$qr_string = $_SESSION['qr_string'];
	}
	
	$title = "Add";
	$delete_btn = 'style="display: none;"';
	$drug_id_field = 'style="display: none;"';
	
	//edit mode
	if(isset($_GET["drugid"])){
		
		$drugid = $_GET["drugid"];
		$title = "Edit";
		$delete_btn = ''; //only appear on edit mode
		$drug_id_field = ''; //only appear on edit mode
		
		
		$sql_med_detail = "SELECT drug_id, name, model, price,status,count
						FROM mst_medicine
						WHERE drug_id='$drugid'";
		$result_med_detail = $conn->query($sql_med_detail);
		list($drug_id,$Name,$Model, $Price,$Status,$Count) = $result_med_detail->fetch_row(); //list out the drug's details
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Bin Details | Inventory Management System</title>
		
		<link rel="stylesheet" href="css/menubar.css">
		<link href="css/menu.css" rel="stylesheet" />
		<link href="css/base.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		
		<!-- <script type="text/javascript">
		function chk_name(){
			if(document.inv_maint_Price.Name.value == ""){
				document.inv_maint_Price.Name.style.border = "2px solid red";
				return false;
			}
			else{
				document.inv_maint_Price.Name.style.border = "";
				return true;
			}
		}
		function chk_cost(){
			if(document.inv_maint_Price.Status.value == "" || isNaN(document.inv_maint_Price.Status.value)){
				document.inv_maint_Price.Status.style.border = "2px solid red";
				return false;
			}
			else{
				document.inv_maint_Price.Status.style.border = "";
				return true;
			}
		}
		function chk_price(){
			if(document.inv_maint_Price.Count.value == "" || isNaN(document.inv_maint_Price.Count.value)){
				document.inv_maint_Price.Count.style.border = "2px solid red";
				return false;
			}
			else{
				document.inv_maint_Price.Count.style.border = "";
				return true;
			}
		}
		function chk_qty(){
			if(document.inv_maint_Price.med_qty.value == "" || !Number.isInteger(parseFloat(document.inv_maint_Price.med_qty.value))){
				document.inv_maint_Price.med_qty.style.border = "2px solid red";
				return false;
			}
			else{
				document.inv_maint_Price.med_qty.style.border = "";
				return true;
			}
		}
		/*function validate(){
			if(chk_name() && chk_cost() && chk_price() && chk_qty()){
				return true;
			}
			else{
				alert("Please check your information again");
				return false;
			}
		}*/
		</script> -->
	</head>
	
	<body>
		
		
		<div class="wrapper">
    <div class="sidebar">

    	<div class="sidebar-wrapper">
            <div class="logo simple-text">   
                   
<?php
	require_once 'php_function/general.php'; //general php function

	echo  "<p>". $_SESSION["sess_uname"] ."</p>" ; 
?>

            </div>

            <ul class=" puerto-menu nav">
		<li>
			<a href="inv_menu.php" target="_self" >

				<p>
					<strong>Home</strong>
					<small>menu</small>
				</p>
			</a>
		</li>
		<li>
			<a href="inv_lst_med.php" target="_self"  class="active">

				<p>
					<strong>Bin</strong>
					<small>listing</small>
				</p>
			</a>
		</li>
		<li>
			<a href="" class="hover">
				<p>
					<strong>Status</strong>
					<small>stock</small>
				</p>
			</a>

			<ul>
				<li><a href="trans_stockinout.php?mode=in" target="_self"></i>Update</a></li>
				<li>
					<a href="trans_stockinout.php?mode=out" target="_self">New</a>
					
				</li>
			</ul>
		</li>
		<li>
			<a href="" class="hover">
				<p>
					<strong>Report</strong>
					<small>table</small>
				</p>
			</a>
			<ul>
				<li><a href="rpt_sales.php" target="_self"></i>Sales Report</a></li>
				<li>
					<a href="rpt_stockinout.php?mode=in" target="_self">Stock In</a>
					
				</li>
				<li><a href="rpt_stockinout.php?mode=out" target="_self">Stock Out</a></li>
			</ul>
		</li>
		<li <?php echo $hidden_userlist; ?>>
			<a href="mst_lst_user.php" target="_self">

				<p>
					<strong>User List</strong>
					<small>account</small>
				</p>
			</a>
		</li>
				
				<li class="active-pro">
	<a href="general_html/logout.php" target="_self">Logout</a>
                </li>
				
            </ul>
    	</div>
    </div>
	
	<div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header navbar-brand">
<?php echo $title; ?> Bin Details | Inventory Management System
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Current Inventory Level</h4>
                            </div>
                            <div class="content table-responsive table table-striped">
		<form name="inv_maint_Price" method="post">
			<table>
				
				<tr <?php echo $drug_id_field; ?>>
					<td>ID: </td>
					<td><input type="text" name="med_id" size="21" value="<?php echo $drug_id; ?>" readonly /></td>
				</tr>
				<tr>
					<td>Name: </td>
					<td><input type="text" name="Name"  size="21" value="<?php echo $Name; ?>"/></td>
				</tr>
				<tr>
					<td>Model</td>
					<td><input type="text" name="Model" value="<?php echo $Model; ?>" size="21"/></td>
				</tr>
				<tr>
					<td>Price</td>
					<td><input type="text" name="Price" value="<?php echo $Price; ?>" size="21"/></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><input type="text" name="Status" value="<?php echo $Status; ?>" size="21"/></td>
				</tr>
				<tr>
					<td>Count</td>
					<td><input type="text" name="Count" value="<?php echo $Count; ?>" size="21"/></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="maint_med_submit" value="Save"/>
						<input type="submit" name="maint_med_delete" value="Recover" <?php echo $delete_btn; ?>/>
						<input type="submit" name="maint_med_cancel" value="Cancel"/>
					</td>
				</tr>
			</table>
			 </div>
                        </div>
                    </div>
			
		</form>
	</body>
</html>

<?php
	//if save button clicked
	if(isset($_POST["maint_med_submit"])){
		$Status = $_POST['Status'];

		if($user_grroup == 2){
		header("Location: inv_lst_med.php");
		}
		$sql_original_med = "SELECT name,model,price,status,count
							FROM mst_medicine
							WHERE drug_id = '$drugid'
							;";
		$result = $conn->query($sql_original_med);
		list($original_name,$original_model,$original_price,$original_status,$original_count) = $result->fetch_row(); //list out the drug's details
//		echo $original_status;
		$Name = $_POST['Name'];
		$Model = $_POST['Model'];
		$Price = $_POST['Price'];
		$Status = $_POST['Status'];
		$Count = $_POST['Count'];

		$option = -1;
		$type=array("name","model","price","status","count");
		$type_value=array($Name,$Model,$Price,$Status,$Count);
		$type_orgi_value=array($original_name,$original_model,$original_price,$original_status,$original_count);
		if($Name != $original_name){
			if($command == NULL)$option=0;
		}
		if($Model != $original_model){
			if($command == NULL)$option=1;
		}
		if($Price != $original_price){
			if($command == NULL)$option=2;
		}
		if($Status != $original_status){
			if($command == NULL)$option=3;
		}
		if($Count != $original_count){
			if($command == NULL)$option=4;
		}
		//if edit mode
		if(isset($drugid)){
			$update_date = time();
			$sql_edit_med = 'UPDATE mst_medicine
							SET name="'.$Name.'", model="'.$Model.'", price="'.$Price.'", status="'.$Status.'", count="'.$Count.'",update_date="'.$update_date.'"
							WHERE drug_id="'.$drugid.'";';
			
			$conn->query($sql_edit_med);
			//echo $sql_edit_med;
			echo "<script>
					alert('Changes Saved');
					location.assign('inv_lst_med.php".$qr_string."');
				</script>";		
			if($option != -1)
			{
				$staff = $_SESSION["sess_uname"];
				$arg = array($drugid,$type[$option],$type_orgi_value[$option],$type_value[$option]);
				$detail = json_encode($arg);

				$sql_add_history = "INSERT INTO history (staff,cmd,detail) VALUES ('$staff','EDIT','$detail');";
				//var_dump($sql_add_history);
				$conn->query($sql_add_history);
			}

		}
		
	}
	else if(isset($_POST["maint_med_delete"])){ //if delete button clicked
		//insert hisory
		$staff = $_SESSION["sess_uname"];
		$arg = array($drugid);
		$detail = json_encode($arg);
		$sql_add_history = "INSERT INTO history (staff,cmd,detail) VALUES ('$staff','RECOVERED','$detail');";
		$conn->query($sql_add_history);
		//var_dump($sql_add_history);
		$sql_delete_med = 'UPDATE mst_medicine SET deleted = "0" WHERE drug_id = "'.$drugid.'"';
		$conn->query($sql_delete_med);
		//echo $sql_delete_med;
		echo "<script>alert('Record Recovered');location.assign('inv_lst_med.php".$qr_string."');</script>";		
	}
	else if(isset($_POST["maint_med_cancel"])){ //if cancel button clicked
		echo "<script>location.assign('inv_lst_med.php".$qr_string."');</script>";	
	}
?>