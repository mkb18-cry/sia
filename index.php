<?php
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<!-- General meta information -->
	<title>SIA STTI NIIT</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="robots" content="index, follow" />
	<meta charset="utf-8" />
	<!-- // General meta information -->
	
	<!-- Load Javascript -->
	<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/jquery.query-2.1.7.js"></script>
	<script type="text/javascript" src="./js/rainbows.js"></script>
	<!-- // Load Javascipt -->

	<!-- Load stylesheets -->
	<link type="text/css" rel="stylesheet" href="css/style.css" media="screen" />
	<!-- // Load stylesheets -->
	
<script>

	$(document).ready(function(){
 
		$("#submit1").hover(
			function() {
				$(this).animate({"opacity": "0"}, "slow");
			},
	
			function() {
				$(this).animate({"opacity": "1"}, "slow");
			}
		);
 	});


</script>
<style>
	.alert {
	  padding: 8px 35px 8px 14px;
	  margin-bottom: 20px;
	  text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	  background-color: #fcf8e3;
	  border: 1px solid #fbeed5;
	  -webkit-border-radius: 4px;
	  -moz-border-radius: 4px;
	  border-radius: 4px;
	  color: #c09853;
	}
	.alert h4 {
	  margin: 0;
	}
	.alert .close {
	  position: relative;
	  top: -2px;
	  right: -21px;
	  line-height: 20px;
	}
	.alert-success {
	  background-color: #dff0d8;
	  border-color: #d6e9c6;
	  color: #468847;
	}
	.alert-danger,
	.alert-error {
	  background-color: #f2dede;
	  border-color: #eed3d7;
	  color: #b94a48;
	}
	.alert-info {
	  background-color: #d9edf7;
	  border-color: #bce8f1;
	  color: #3a87ad;
	}
	.alert-block {
	  padding-top: 14px;
	  padding-bottom: 14px;
	}
	.alert-block > p,
	.alert-block > ul {
	  margin-bottom: 0;
	}
	.alert-block p + p {
	  margin-top: 5px;
	}
</style>
	
</head>
<body>

	<div id="wrapper">
		<img src="logo.jpg" width="350"><br><br>
		<p align="center" style="font-size: 15px; font-weight: bold;">Sistem Informasi Akademik Online</p>
		<?php
		if ($_GET['code'] == 1){
		?>
		<div class="alert alert-danger">
			Username (E-mail) atau Password salah.
		</div>
		<?php
		}
		if ($_GET['code'] == 2){
		?>
		<div class="alert alert-success">
			Anda telah keluar (Logout)
		</div>
		<?php
		}
		?>
		<div id="wrappertop"></div>
		<div id="wrappermiddle">
			<h2>Login</h2>
			<form method="POST" action="cek_login.php">
			<div id="username_input">

				<div id="username_inputleft"></div>

				<div id="username_inputmiddle">
					<input type="text" name="username" id="url" value="E-mail Address" onclick="this.value = ''">
					<img id="url_user" src="./images/mailicon.png" alt="" />
				
				</div>

				<div id="username_inputright"></div>

			</div>

			<div id="password_input">

				<div id="password_inputleft"></div>

				<div id="password_inputmiddle">
					<input type="password" name="password" id="url" value="" placeholder="Password" onclick="this.value = ''" />
					<img id="url_password" src="./images/passicon.png" alt="" />
				</div>

				<div id="password_inputright"></div><br />
				<p><input type="checkbox" name="dosen" value="1" /> Kotak Dosen</p>
			</div>
			<br>
			<div id="submit">
				<input type="image" src="./images/submit_hover.png" id="submit1" value="Sign In">
				<input type="image" src="./images/submit.png" id="submit2" value="Sign In">
			</div>
			</form>

			<div id="links_left"></div>
			<div id="links_right"></div>

		</div>

		<div id="wrapperbottom"></div>
		
	
	</div>

</body>
</html>