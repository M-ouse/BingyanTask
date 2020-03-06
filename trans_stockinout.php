<?php
	require_once 'php_function/general.php'; //general php function
	require_once 'php_function/function_report.php';
	
	/*get user information*/
	$user_name = $_SESSION["sess_uname"];
	$user_id = $_SESSION["sess_uid"];
	$user_grroup = $_SESSION["sess_ugroup"];


	/*2 level user cannnot visit this page*/
	if($user_grroup == 2)
	{
		header("Location: index.php");
	}


	/*get whether it is stock in or out*/
	$mode = $_GET["mode"];
	
	if($mode == "in"){
		$title = "New";
	}
	else if($mode == "out"){
		$title = "Update";
	}
	
	$combobox = datalist_medicine($conn,"trans");
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?> | Inventory Management System</title>
		
		<link href="css/general.css" rel="stylesheet" type="text/css"/>
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		<link rel="stylesheet" href="css/menubar.css">
		<link href="css/menu.css" rel="stylesheet" />
		<link href="css/base.css" rel="stylesheet"/>
		<script src="javascript_function/general.js" type="text/javascript"></script>
		
	</head>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script>
		function DoData()
		{
			 var name = stockin_frm.product_name.value;
			 var model = stockin_frm.product_model.value;
			 var price = stockin_frm.product_price.value;
			 var count = stockin_frm.product_count.value;
			 var comment = stockin_frm.product_comment.value;

			 var cont = {"name":name,"mode":model,"price":price,"count":count,"comment":comment};
			 const conte = JSON.stringify(cont);
			 //alert(cont);
			 path = '/test5/trans_stockinout.php'
			$.ajax({
			    url: path,
			    type: "POST",
			    data: conte,
			    contentType: 'charset=UTF-8',
			    success: function(result){ 
       				alert("Success"); 
    			}
			  });
		}
	</script>>
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
			<a href="inv_lst_med.php" target="_self">

				<p>
					<strong>Products</strong>
					<small>listing</small>
				</p>
			</a>
		</li>
		<li>
			<a href="" class="hover active">
				<p>
					<strong>Status</strong>
					<small>stock</small>
				</p>
			</a>
			<ul>
				<li><a href="trans_stockinout.php?mode=in" target="_self"></i>New</a></li>
				<li>
					<a href="trans_stockinout.php?mode=out" target="_self">Update</a>
					
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
<?php echo $title; ?>  | Inventory Management System
                </div>
            </div>
        </nav>
		
		
	 <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-11">
                        <div class="card">
                            <h3><?php echo $title; ?></h3>
							
                            <div class="content table-striped2 table ">
		
		<p>Date: <?php echo date("Y-m-d")." (".date("l").")"; ?></p>
		<p>Time: <?php echo date("h:ia"); ?></p>
		<p>User: <?php echo $user_name; ?></p>
		<form name="stockin_frm" method="post" action="">
			<table id="input_table">
				<tr>
				</tr>
				<tr>
					<td>Product Name</td>
					<td>Model</td>
					<td>Price</td>
					<td>Count</td>
					<td>comment</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="product_name" size="40">
					</td>
					<td><input type="text" name="product_model" size="3"></td>
					<td>
						<input type="text" name="product_price" size="3" >
					</td>
					<td><input type="text" name="product_count" size="3" ></td>
					<td><input type="text" name="product_comment"size="50"></td>
					<?php echo $combobox; ?>
				</tr>
			</table>
			<!--<p id="grand_total">Grand Total: 0.00</p>-->
			<input type="button" name="add_row" value="Add New Row" onclick="add_new_row();count_total_row();"/>
						<input type="button" name="remove_row"  value="Remove Last Row" onclick="remove_last_row();count_total_row();"/>
						<input type="hidden" name="hid_total_row" value="1"/>
						<input type="hidden" name="hid_mode" id="hid_mode" value="<?php echo $mode; ?>"/>
			
			<input style="float:right"type="button" value="Cancel" onclick="cancel_button();"/>
			<input style="float:right"type="submit" name="submit_stockin" value="Confirm" onclick="DoData();"/>
		</form>
		<a href="batch_upload.php"><button>Batch Upload</button></a>
	</body>
</html>

<?php
	//if save button clicked

		if(isset($_POST['product_name']))
	{

		/*insert date*/
		$date = time();
		
		/*insert time*/

		$name =  $_POST['product_name'];
		$model = $_POST['product_model'];
		$price = $_POST['product_price'];
		$status = "IN";
		$count = $_POST['product_count'];
		$comment = $_POST['product_comment'];
 
		if($title = "New");
		{

			$sql_insert_trans = "INSERT INTO mst_medicine (name,model,price,status,count,create_date,update_date,comment,staff) VALUES ('$name','$model','$price','$status','$count','$date','$date','$comment','$user_name');";
			$conn->query($sql_insert_trans);
			//echo $sql_insert_trans;

			//insert hisory


			$sql_query_last = "SELECT drug_id FROM mst_medicine ORDER BY drug_id DESC LIMIT 1;";
			$result = $conn->query($sql_query_last);
			$arg = $result->fetch_assoc();
			//echo $arg['drug_id'];

			//sbscribe
			$email = $_SESSION["email"];
			$drugid = $arg['drug_id'];
			$sql_insert_sub = "INSERT INTO subscribe (id,email) VALUES ('$drugid','$email');";
			$conn->query($sql_insert_sub);
			//email
			
			$detail = json_encode(array($arg['drug_id'],$count));
			$sql_add_history = "INSERT INTO history (staff,cmd,detail) VALUES ('$user_name','CREATE','$detail');";
			$conn->query($sql_add_history);
		}
		/*insert into database*/
		
		
		/*notify the user that the process is done successfully*/
		echo "<script>alert('Transaction Done');</script>";
	}
?>