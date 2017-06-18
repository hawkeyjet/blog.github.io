<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once "htmlout.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title><?php echo htmlout($results['pageTitle'])?></title>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
	</head>
	<body>
		<script src="js/jquery-3.2.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<div class="container">
			<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href=".">Главная</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href=".?action=archive">Все записи <span class="sr-only">(current)</span></a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<a href="admin.php"><button type="button" class="btn btn-default navbar-btn">Вход Администратора</button></a>
					</ul>
				</div>
			</div>
		</nav>
