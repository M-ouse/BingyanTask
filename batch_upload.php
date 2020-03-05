<?php
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


	/*2 level user cannnot visit this page*/
	if($user_grroup == 2)
	{
		header("Location: index.php");
	}
	//echo "Hello"." ".$user_name;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Batch Upload</title>
    <meta charset="utf-8">
</head>
    <form action="do.php" method="post" enctype="multipart/form-data">
        <input type="file" name="excel">
        <input type="submit" value="预览">
    </form>
</body>
</html>
<!-- <html>
	<title>Batch Upload</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script>
		function upload(){
        var file_name=$("#file").val();
        var file_siffix =file_name.replace(/.+\./,"");
        if(file_siffix=="xls"||file_siffix=="xlsx" ){ 

            var form = new FormData(document.getElementById("upfile"));
            $.ajax({
                url:"/test5/batch_upload.php",
                type:"POST",
                data:form,
                processData:false,
                contentType:false,
                error:function(msg){                 
                },
                success:function(msg){                   
                }
            })

        }else{
            alert("请上传.xls/.xlsx后缀的表格");
        }

    }
	</script>
	<body>
		<form id="upfile" enctype="multipart/form-data">
                <input  type="file"class="form-control" name="file" id="file" style="width:600px;"  >
                <button class="btn btn-warning" id="conds" onclick="upload()"><i class="icon-cog"></i>上传</button>
            </form>
	</body>
</html> -->