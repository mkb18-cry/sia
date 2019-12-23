<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SIA STTI NIIT</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="STTI NIIT">
    
    
	<link rel="stylesheet" type="text/css" href="../css/reset.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/text.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/grid.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/layout.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/nav.css" media="screen" />
	<!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" /><![endif]-->
	<!-- BEGIN: load jquery -->
	<script src="../js/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../js/jquery-ui/jquery.ui.core.min.js"></script>
    <script src="../js/jquery-ui/jquery.ui.widget.min.js" type="text/javascript"></script>
    <script src="../js/jquery-ui/jquery.ui.accordion.min.js" type="text/javascript"></script>
    <script src="../js/jquery-ui/jquery.effects.core.min.js" type="text/javascript"></script>
    <script src="../js/jquery-ui/jquery.effects.slide.min.js" type="text/javascript"></script>
    <script src="../js/jquery-ui/jquery.ui.mouse.min.js" type="text/javascript"></script>
    <script src="../js/jquery-ui/jquery.ui.sortable.min.js" type="text/javascript"></script>
    <script src="../js/table/jquery.dataTables.min.js" type="text/javascript"></script>
    <!-- END: load jquery -->
    <script src="../js/setup.js" type="text/javascript"></script>
	<!-- END: load jqplot -->
	
	<link rel="stylesheet" href="../js/development-bundle/themes/base/jquery.ui.all.css" type="text/css">
	<script type="text/javascript" src="../js/development-bundle/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="../js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="../js/development-bundle/ui/jquery.ui.widget.js"></script>
	
	<script src="../js/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>
	
	<script type="text/javascript">
		$(document).ready(function () {
			setupLeftMenu();
			setSidebarHeight();
			
			$('.datatable').dataTable({
				'iDisplayLength': 50
			});
			
			$('#menu2').tabify();
		});
	</script>
	
	<style>
		.error {
			font-size:small; 
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
	  		border-color: #eed3d7;
	  		color: #b94a48; 
		}
		
		.menu2 { 
			padding: 0; 
			clear: both; 
		}
		
		.menu2 li { 
			display: inline; 
		}
		
		.menu2 li a { 
			background: #ccf; 
			padding: 10px; 
			float:left; 
			border-right: 1px solid #ccf; 
			border-bottom: none; 
			text-decoration: none; 
			color: #000; 
			font-weight: bold;
		}
		
		.menu2 li.active a { 
			background: #eef; 
		}
		
		.content2 { 
			float: left; 
			clear: both; 
			border: 1px solid #ccf; 
			border-top: none; 
			border-left: none; 
			background: #eef; 
			padding: 10px 20px 20px; 
			width: 96%; 
		}
	</style>
    
	<script type="text/javascript" src="../js/ckeditor/ckeditor.js"></script>
</head>

<body>
	<div class="container_12">
		<div class="grid_12 header-repeat">
			<div id="branding">
				<div class="floatleft">
					<!--<img src="../logo.jpg" alt="Logo" width="300">-->
                    <img src="../logo itech.png" alt="Logo STTI NIIT" width="300" />
				</div>
				<!--<div class="floatright">
					<div class="floatleft">
						<img src="../img/img-profile.jpg" alt="Profile Pic" />
					</div>
					<div class="floatleft marginleft10">
						<ul class="inline-ul floatleft">
							<li>Hello Admin</li>
							<li><a href="#">Config</a></li>
							<li><a href="#">Logout</a></li>
						</ul>
						<br />
						<span class="small grey">Last Login: 3 hours ago</span>
					</div>
				</div>-->
				
				<div class="clear"></div>
			</div>
		</div>

		<div class="clear"></div>
		
		<div class="grid_12">
			<ul class="nav main">
				<li class="ic-dashboard"><a href="index.php"><span>Home</span></a> </li>
				<li class="ic-form-style"><a href="?mod=ubah_password"><span>Ubah Password</span></a></li>
				<li class="ic-typography"><a href="../logout.php"><span>Logout</span></a></li>
			</ul>
		</div>
		
		<div class="clear"></div>

		<?php include "navigation.php"; ?>
		
        <div class="grid_10">
			<div class="box round first">
				<div class="block">
					<!-- paragraphs -->
					<p class="start">
						<?php include "konten.php"; ?>
					</p>
				</div>
			</div>
		</div>
		
		<div class="clear"></div>
	</div>

	<div class="clear"></div>

</body>
</html>