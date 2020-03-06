<?php
	require_once 'php_function/general.php'; //general php function
	require_once 'subscribe.php'; //subscribe fun
	$user_name = $_SESSION["sess_uname"];
	$user_id = $_SESSION["sess_uid"];
	$user_grroup = $_SESSION["sess_ugroup"];

	require_once 'php_function/general.php'; //general php function
    
    if($_SESSION["sess_ugroup"] == 2){
        header("Location: inv_menu.php");
    }
	require_once('./Classes/PHPExcel/IOFactory.php');

	//echo $filePath;
	/*读取excel文件，并进行相应处理*/
	//$fileName = "url.xls";
	$fileName = $_SESSION["filename"];
	$startTime = time(); //返回当前时间的Unix 时间戳

	$objPHPExcel = PHPExcel_IOFactory::load($fileName);//获取sheet表格数目
	$sheetCount = $objPHPExcel->getSheetCount();//默认选中sheet0表
	$sheetSelected = 0;$objPHPExcel->setActiveSheetIndex($sheetSelected);//获取表格行数
	$rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();//获取表格列数
	$columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
	//echo "<div>Sheet Count : ".$sheetCount."　　行数： ".$rowCount."　　列数：".$columnCount."</div>";
	$dataArr = array();
	/* 循环读取每个单元格的数据 */
	//行数循环
	//循环内语句需要的预处理变量
	$date = time();
	$arg = array("Name","Model","Price","Count","comment");
	$status = "IN";

	for ($row = 2; $row <= $rowCount; $row++)
	{//start from line2
	//列数循环 , 列数是以A列开始
		$index = 0;
	    for ($column = 'A'; $column <= $columnCount; $column++)
	    {
	        $dataArr[] = $objPHPExcel->getActiveSheet()->getCell($column.$row)->getValue();
	        //echo $column.$row.":".$objPHPExcel->getActiveSheet()->getCell($column.$row)->getValue()."<br />";
	        $arg[$index++] = $objPHPExcel->getActiveSheet()->getCell($column.$row)->getValue();
	    //var_dump($arg);

	    }
		    $sql_insert_trans = "INSERT INTO mst_medicine (name,model,price,status,count,create_date,update_date,comment,staff) VALUES ('$arg[0]','$arg[1]','$arg[2]','$status','$arg[3]','$date','$date','$arg[4]','$user_name');";
			$conn->query($sql_insert_trans);
			//echo $sql_insert_trans."<br>";

			//insert hisory


			$sql_query_last = "SELECT drug_id FROM mst_medicine ORDER BY drug_id DESC LIMIT 1;";
			$result = $conn->query($sql_query_last);
			$arg_id = $result->fetch_assoc();
			//echo $arg['drug_id'];
			
			$detail = json_encode(array($arg_id['drug_id'],$arg[3]));
			$sql_add_history = "INSERT INTO history (staff,cmd,detail) VALUES ('$user_name','CREATE','$detail');";
			$conn->query($sql_add_history);

			/*insert into database*/


			$email = $_SESSION["email"];
			$drugid = $arg_id['drug_id'];
			$sql_insert_sub = "INSERT INTO subscribe (id,email) VALUES ('$drugid','$email');";
			//echo $sql_insert_sub;
			$conn->query($sql_insert_sub);
		    //echo "<br/>消耗的内存为：".(memory_get_peak_usage(true) / 1024 / 1024)."M";
		    //$endTime = time();
		    //echo "<div>解析完后，当前的时间为：".date("Y-m-d H:i:s")."　　　
			//总共消耗的时间为：".(($endTime - $startTime))."秒</div>";
		    //var_dump($dataArr);
	    	$dataArr = NULL;
	}
	echo "<script>alert('Success');location.assign('trans_stockinout.php?mode=in');</script>";		
?>