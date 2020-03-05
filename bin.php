<?php
	require_once 'php_function/general.php'; //general php function
	/*get the url parameter string*/
	reset ($_GET);
	$qr_string = "?";
	while (list ($key, $val) = each ($_GET)) {
		$qr_string .= "$key=$val&";
	}
	$_SESSION['qr_string'] = $qr_string;
	$user_grroup = $_SESSION["sess_ugroup"];
	if($user_grroup == 2)
	{
		header("Location: index.php");
	}
	/*end - get the url parameter string*/

	/*initialise variable*/
	$where = " WHERE 1=1 ";
	
	//product that need to re-order
	if(isset($_GET["type"])){
		$type = $_GET["type"];
		
		if($type == "reorder"){
			$title = "(To re-order)";
			$where = " AND inv_qty < 10 ";
		}
	}
	//end - product that need to re-order
	
	/*search function*/
	if(isset($_GET["f_med_submit"])){
		//echo $Status;
		if($f_med_id != ""){
			$where .= " AND drug_id = '$f_med_id' ";
		}
		if($f_med_name != ""){
			$where .= " AND name LIKE '%".trim($f_med_name)."%'";
			//$where .= " AND name = '$f_med_name' ";
		}
		if($model != ""){
			$where .= " AND model = '$model' ";
		}
		if($CreateDate != ""){
			$CreateDate = strtotime($CreateDate);
			//var_dump($CreateDate);
			/*$max_time = $CreateDate+86400;
			$min_time = $CreateDate-86400;*/
			$max_time = $CreateDate+50000;
			$min_time = $CreateDate-50000;
			$where .= " AND (create_date <= '$max_time' AND create_date >= '$min_time')";
		}
		if($Status != ""){
			$where .= " AND status = '$Status' ";
		}
		/*if((!is_numeric($f_med_id) && $f_med_id != "") || (!is_numeric($f_med_name) && $f_med_name != "") || (!is_numeric($model) && $model != "") || (!is_numeric($CreateDate) && $CreateDate != "") || (!is_numeric($Status) && $Status != "")){
			$where .= "AND 1 != 1";
		}*/
	}
	/*end - search function*/
	
	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Bin | Management System</title>
		<link href="css/general.css" rel="stylesheet" type="text/css"/>
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		<link rel="stylesheet" href="css/menubar.css">
		<link href="css/menu.css" rel="stylesheet" />
		<link href="css/base.css" rel="stylesheet"/>
	</head>
	
	<body>
		<div class="wrapper">
    <div class="sidebar">

    	<div class="sidebar-wrapper">
            <div class="logo simple-text">   
                   
<?php
	require_once 'php_function/general.php'; //general php function
	if($user_grroup == 2)
	{
		header("Location: index.php");
	}
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
			<a href="inv_lst_med.php" target="_self" class="active" >

				<p>
					<strong>Products</strong>
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
				<li><a href="rpt_sales.php" target="_self"></i>Report</a></li>
				<li>
					<a href="rpt_stockinout.php?mode=in" target="_self">New</a>
					
				</li>
				<li><a href="rpt_stockinout.php?mode=out" target="_self">Update</a></li>
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
Bin Listing  | Management System
                </div>
            </div>
        </nav>
	
	
	
		<div class="content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="content table">
		<form name="search_form" method="get" action="">

			<table>
				<h3>Search Bin</h3>
				<tr>
					<td>ID:</td>
					<td colspan="3"><input type="text" name="f_med_id" size="30" value="<?php echo $f_med_id; ?>"></td>
				</tr>
				<tr>
					<td>Name:</td>
					<td colspan="3"><input type="text" name="f_med_name" size="30" value="<?php echo $f_med_name; ?>"></td>
				</tr>
				<tr>
					<td>Model:</td>
					<td><input type="text" name="model" size="10" value="<?php echo $model; ?>"></td>
				</tr>
				<tr>
					<td>CreateDate:</td>
					<td><input type="date" name="CreateDate" size="10" value="<?php echo $CreateDate; ?>"></td>
				</tr>
				<tr>
					<td>Status:</td>
					<td><input type="text" name="Status" size="10" value="<?php echo $Status; ?>"></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="3">
						<input type="submit" name="f_med_submit" value="Search">
						<input type="reset" name="f_med_reset" value="Reset">
					</td>
				</tr>
			</table>
			</div></div></div> 
          
		
			
			<input type="hidden" name="type" value="<?php echo $type ?>"/>
		</form>
		<!--end filter-->
		
		<!--medicines listing-->
		<div class="content">

                    <div class="col-md-8">
                        <div class="card">
                          <div class="content table-responsive  table table-striped">
		<table>
			<h3>Bin Listing <a style="font-size:20px;float:right;padding-right:30px;"href="history.php" target="_self">History</a>
				<a style="font-size:20px;float:right;padding-right:30px;"href="bin.php" target="_self">Bin</a><?php echo $title ?></h3>
			<tr>
				<th><a href="bin.php<?php echo $qr_string."sort=medid" ?>" target="_self">ID</a></th>
				<th><a href="bin.php<?php echo $qr_string."sort=medname" ?>" target="_self">Name</a></th>
				<th><a href="bin.php<?php echo $qr_string."sort=meddosage" ?>" target="_self">CreateTime</a></th>
				<th><a href="bin.php<?php echo $qr_string."sort=medamount" ?>" target="_self">Status</a></th>
				<!--<th>Category</th>-->
			</tr>
			<?php
			
			/*pagination*/
			$per_page=20;
			if(isset($_GET["page"])){
				$page = $_GET["page"];
			}
			else{
				$page=1;
			}
			
			// Page will start from 0 and Multiple by Per Page
			$start_from = ($page-1) * $per_page;

			$sql_med_lst = "SELECT drug_id, name, create_date, status,deleted
							FROM mst_medicine
							$where
							;";
			//echo $sql_med_lst;
			$result_med_lst = $conn->query($sql_med_lst);
			
			//list down the records
			if ($result_med_lst->num_rows > 0) {				
				while($row = $result_med_lst->fetch_assoc()){
					if($row['deleted'] == 1)
					{
						echo 
						"
						<tr>
							<th><a href='bin_maint_med.php?drugid=".$row["drug_id"]."' target='_self'>".$row["drug_id"]."</a></th>
							<td>".$row["name"]."</td>
							<td>".date('Y-m-d h:m:s',$row["create_date"])."</td>
							<td>".$row["status"]."</td>
						</tr>
						";
					}
				}
			}
			else{
				echo
				"<tr>
					<td colspan='7'>no record found</td>
				</tr>
				";
			}
			?>
		</table>
		
		<?php
		$total_pages = ceil($total_line / $per_page);
		
		if($total_pages > 1){
			//Going to first page
			echo "<a href='bin.php".$qr_string."page=1'><<&nbsp;&nbsp;</a>";

			for ($i=1; $i<=$total_pages; $i++) {
				if($_GET['page']==$i)
				{
					$selected_page = "style='color:red;'";
				}
				else{
					$selected_page = "";
				}
				echo "<a href='bin.php".$qr_string."page=".$i."' ".$selected_page.">".$i."&nbsp;&nbsp;</a>";
			};
			// Going to last page
			echo "<a href='bin.php".$qr_string."page=$total_pages'>>>&nbsp;&nbsp;</a>";
		}
		/*end pagination*/
		?>
	

		<!--end medicines listing-->
	</body>
</html>