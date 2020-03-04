<?php
	require_once 'php_function/general.php'; //general php function
	
	//for the inventory level
	$sql_product_available = "SELECT COUNT(1) FROM mst_medicine INNER JOIN inventory ON drug_id = inv_prd_id WHERE inv_qty > 0;";
	$result_product_available = $conn->query($sql_product_available);
	list($product_available) = $result_product_available->fetch_row();
	
	$sql_total_qty = "SELECT SUM(inv_qty) FROM inventory;";
	$result_total_qty = $conn->query($sql_total_qty);
	list($total_qty) = $result_total_qty->fetch_row();
	
	$sql_reorder_required = "SELECT COUNT(1) FROM inventory WHERE inv_qty < 10;";
	$result_reorder_required = $conn->query($sql_reorder_required);
	list($reorder_required) = $result_reorder_required->fetch_row();
	//end inventory level
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Main Menu | Inventory Management System</title>
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

	echo  "<p>". $_SESSION["sess_uname"] ."</p>" ; 
?>

            </div>

            <ul class=" puerto-menu nav">
		<li>
			<a href="inv_menu.php" target="_self" class="active">

				<p>
					<strong>Home</strong>
					<small>menu</small>
				</p>
			</a>
		</li>
		<li>
			<a href="inv_lst_med.php" target="_self" >

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
				<li>
					<a href="trans_stockinout.php?mode=in" target="_self"></i>New</a></li>
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
				<li>
					<li>
					<a href="rpt_sales.php" target="_self"></i>Report</a></li>
				<li>
					<a href="rpt_stockinout.php?mode=in" target="_self">New</a>
					
				</li>
				<li><a href="rpt_stockinout.php?mode=out" target="_self">Update</a></li>
				
		</li>
		
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
Main Menu | Inventory Management System
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <strong>Current Inventory</strong>
                            </div>
                            <div class="content table-responsive table table-striped">
		<table>
			<tr>
				<th>Product Available</th>
				<th>Quantity</th>
				<th>Product to Re-Order</th>
			</tr>
			<tr>
				<td><?php echo $product_available; ?></td>
				<td><?php echo $total_qty; ?></td>
				<td><a href="inv_lst_med.php?type=reorder" target="_self"><?php echo $reorder_required; ?></a></td>
			</tr>
		</table>
		  </div>
                        </div>
                    </div>
		
		
		
		<!--medicines listing-->
		<div class="content">

                    <div class="col-md-8">
                        <div class="card">
                          <div class="content table-responsive  table table-striped">
		<table>
			<!-- <h3>Products Listing <a style="font-size:20px;float:right;padding-right:30px;"href="inv_maint_med.php" target="_self">Add New</a><?php echo $title ?></h3> -->
			<tr>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=medid" ?>" target="_self">ID</a></th>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=medname" ?>" target="_self">Name</a></th>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=meddosage" ?>" target="_self">CreateTime</a></th>
				<th><a href="inv_lst_med.php<?php echo $qr_string."sort=medamount" ?>" target="_self">Status</a></th>
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
			/*end pagination*/
			
			//top 10 product need to re-order
			/*$sql_med_lst = "SELECT drug_id, drug_name, drug_dosage, drug_form, drug_cost, drug_price, inv_qty
							FROM mst_medicine
							INNER JOIN inventory ON inv_prd_id = drug_id 
							$where
							ORDER BY $sortby drug_id ASC
							LIMIT $start_from,$per_page
							;";*/
			$sql_med_lst = "SELECT drug_id, name, create_date, status
							FROM mst_medicine
							$where
							;";
			//echo $sql_med_lst;
			$result_med_lst = $conn->query($sql_med_lst);
			
			//list down the records
			if ($result_med_lst->num_rows > 0) {				
				while($row = $result_med_lst->fetch_assoc()){
					echo 
					"
					<tr>
						<td>".$row["drug_id"]."</td>
						<td>".$row["name"]."</td>
						<td>".date('Y-m-s h:i:s',$row["create_date"])."</td>
						<td>".$row["status"]."</td>
					</tr>
					";
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
		/*pagination*/
		$sql_total_line = "SELECT COUNT(1)
						FROM mst_medicine
						INNER JOIN inventory ON inv_prd_id = drug_id 
						$where";
		$result_total_line = $conn->query($sql_total_line);
		list($total_line) = $result_total_line->fetch_row(); //total of the records

		//Using ceil function to divide the total records on per page
		$total_pages = ceil($total_line / $per_page);
		
		if($total_pages > 1){
			//Going to first page
			echo "<a href='inv_lst_med.php".$qr_string."page=1'><<&nbsp;&nbsp;</a>";

			for ($i=1; $i<=$total_pages; $i++) {
				if($_GET['page']==$i)
				{
					$selected_page = "style='color:red;'";
				}
				else{
					$selected_page = "";
				}
				echo "<a href='inv_lst_med.php".$qr_string."page=".$i."' ".$selected_page.">".$i."&nbsp;&nbsp;</a>";
			};
			// Going to last page
			echo "<a href='inv_lst_med.php".$qr_string."page=$total_pages'>>>&nbsp;&nbsp;</a>";
		}
		/*end pagination*/
		?>
			
			
			
 <!-- <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
						<div class="header">
                                <strong>Top 10 Sales This Month (By Quantity)</strong>
                            </div>
                            <div class="content table-responsive  table table-striped">
                                <?php
			$sql_top10 = "SELECT
								CASE WHEN (drug_form = '' OR drug_form IS NULL) AND (drug_dosage = '' OR drug_dosage IS NULL)
								THEN drug_name
								ELSE CASE WHEN drug_form = '' OR drug_form IS NULL 
								THEN CONCAT(drug_name,' (',drug_dosage,')')
								ELSE CASE WHEN drug_dosage = '' OR drug_dosage IS NULL
								THEN CONCAT(drug_name,' (',drug_form,')')
								ELSE CONCAT(drug_name,' (',drug_dosage,' ',drug_form,')') END END END
								AS drug, 
								SUM(trans_qty_out) AS total_qty,
								(SUM(trans_qty_out) * (drug_price-drug_cost)) AS total_profit
								FROM transactions
								INNER JOIN mst_medicine
								ON trans_prd_id = drug_id
								WHERE (trans_qty_out != 0 OR trans_qty_out IS NOT NULL)
								AND YEAR(NOW()) = YEAR(trans_date) AND MONTH(NOW()) = MONTH(trans_date)
								GROUP BY trans_prd_id
								ORDER BY SUM(trans_qty_out) DESC, drug ASC
								LIMIT 10;";
			$result_top10 = $conn->query($sql_top10);

			if ($result_top10->num_rows > 0) {
				
				echo 
				"
				<table>
					<tr>
						<td>Medicine</td>
						<td>Sold Quantity</td>
						<td>Total Profit</td>
					</tr>
				";
				
				while($row = $result_top10->fetch_assoc()){
					echo 
					"
					<tr>
						<td>".$row["drug"]."</td>
						<td>".$row["total_qty"]."</td>
						<td>".$row["total_profit"]."</td>
					</tr>
					";
				}
				
				echo "</table>";
				echo "<br/>";
			}
		?>
                            </div>
                        </div>
                    </div>
	</body> -->
</html>