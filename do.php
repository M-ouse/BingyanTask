<?php
	//var_dump($_FILES);
	require_once 'php_function/general.php'; //general php function
    
    if($_SESSION["sess_ugroup"] == 2){
        header("Location: inv_menu.php");
    }
	require_once 'php_function/general.php'; //general php function
	require_once 'php_function/function_report.php';
	/*get user information*/
	$user_name = $_SESSION["sess_uname"];
	$user_id = $_SESSION["sess_uid"];
	$user_grroup = $_SESSION["sess_ugroup"];

	$filename=$_FILES['excel']['name'];
	$type=$_FILES['excel']['type'];
	$tmp_name=$_FILES['excel']['tmp_name'];
	$size=$_FILES['excel']['size'];
	$error=$_FILES['excel']['error'];
 	
	copy($tmp_name, "upload/".$filename);

	//echo "<script>alert('Upload Successfully');location.assign('trans_stockinout.php?mode=in');</script>";		
?>
<?php
	require_once('./Classes/PHPExcel/IOFactory.php');
	$filePath = "./upload/".$filename;
	$_SESSION["filename"]=$filePath;
	//echo $filePath;
	/*读取excel文件，并进行相应处理*/
	//$fileName = "url.xls";
	$fileName = $filePath;
	if (!file_exists($fileName)) {
	    exit("文件".$fileName."不存在");
	}
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

	for ($row = 1; $row <= $rowCount; $row++)
	{//start from line2
	//列数循环 , 列数是以A列开始
	    for ($column = 'A'; $column <= $columnCount; $column++)
	    {
	        $dataArr[] = $objPHPExcel->getActiveSheet()->getCell($column.$row)->getValue();
	        //echo $column.$row.":".$objPHPExcel->getActiveSheet()->getCell($column.$row)->getValue()."<br />";
	        echo $objPHPExcel->getActiveSheet()->getCell($column.$row)->getValue();
	        echo " | ";
	    //var_dump($arg);

	    }
	    echo "<br />";
			//echo $sql_insert_trans."<br>";
			//insert hisory
			//echo $arg['drug_id'];
			/*insert into database*/
		    //echo "<br/>消耗的内存为：".(memory_get_peak_usage(true) / 1024 / 1024)."M";
		    //$endTime = time();
		    //echo "<div>解析完后，当前的时间为：".date("Y-m-d H:i:s")."　　　
			//总共消耗的时间为：".(($endTime - $startTime))."秒</div>";
		    //var_dump($dataArr);
	    	$dataArr = NULL;
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Preview</title>
    <meta charset="utf-8">
</head>
    <form action="read.php" method="post">
        <input type="submit" value="提交" name="submit" >
    </form>
</body>
</html>