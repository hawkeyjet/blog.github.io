<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once "htmlout.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo htmlout($results['pageTitle'])?></title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<div id="container">

			<a href="."><img id="logo" src="images/logo.jpg" alt="Лого" /></a>