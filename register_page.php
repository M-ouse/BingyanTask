<!DOCTYPE html>
<html>
	<head>
		<title>Login | Pharmacy Inventory Management System</title>
		
		<link rel="shortcut icon" href="img/bluepharmacy_icon.png"/>
		<link href="css/login.css" rel="stylesheet" type="text/css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<script type="text/javascript">
		function check_email() //validate the email
		{
			if (document.login_frm.u_email.value == "" || !(isNaN(document.login_frm.u_email.value)) || document.login_frm.u_email.value.indexOf("@") == -1 || document.login_frm.u_email.value.indexOf(".com") == -1)
			{
				document.getElementById('EmailError').innerHTML = ' Enter the correct email';		
				return false;
			}
			else
			{
				document.getElementById('EmailError').innerHTML = '&nbsp;';
				return true;
			}
		}
		
		function check_pw() //validate the password
		{
			if (document.login_frm.u_password1.value == "")
			{
				document.getElementById('PwError1').innerHTML = ' Enter your password';
				return false;
			}
			else
			{
				document.getElementById('PwError1').innerHTML = '&nbsp;';
				return true;
			}
		}
		
		function check_same() //make sure the two passwords are the same
		{
			if (document.login_frm.u_password2.value != document.login_frm.u_password1.value)
			{
				document.getElementById('PwError2').innerHTML = 'Two passwords are inconsistent!';
				return false;
			}
			else
			{
				document.getElementById('PwError2').innerHTML = '&nbsp;';
				return true;
			}
		}

		function validatelogin() //double validate while 'Sign In' button clicked
		{
			if (check_email() && check_pw())
			{
				return true;
			}
			else
			{
				alert("Please check your information again");
				return false;
			}
		}
		function doUserRegister()
		{
			 var email = login_frm.u_email.value;
			 var password = login_frm.u_password2.value;
			 //alert(passwd);
			 //var cont = {"email": "1234", "passwd": "1234"};//
			 var cont = {"email":email,"passwd":password};
			 const conte = JSON.stringify(cont);
			 //console.log()
			 //alert(conte);
			 path = '/test5/register.php'
			$.ajax({
			    url: path,
			    type: "POST",
			    data: conte,
			    contentType: 'charset=UTF-8',
			    success: function(result){ 
					window.location.href="index.php";
    			}
			  });
		}
		</script>
	</head>
	
	<body>
	<div class="container">
		<div class="login">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Inventory System</h3>
				</div>
					<div class="panel-body">
					
		<form name="login_frm" method="post" action="" onsubmit="return validatelogin();">
		
		<fieldset>
			<div class="form-group">
									<input type="email" name="u_email" placeholder="user@user_email.com" size="37" maxlength="45" id="email" autofocus required oninput="check_email();"/>
									<span id="EmailError" class="red" >&nbsp;</span>
								</div>
                                <div class="form-group">
                                    <input type="password" name="u_password1" placeholder="Your Password" size="37" oninput="check_pw();"/>
								<span id="PwError1" class="red">&nbsp;</span>
								<div class="form-group">
                                    <input type="password" name="u_password2" placeholder="Your Password Again." size="37" oninput="check_same();"/>
								<span id="PwError2" class="red">&nbsp;</span>
			<br>
					<button class="btn" onclick="doUserRegister();">Register</button>

		</form>
	</body>
</html>
