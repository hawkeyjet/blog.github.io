<?php
	try {
		$pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
		$pdo->exec("SET NAMES 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		$e = 'Не удалось подключиться к серверу баз данных.';
		error_log($e->getMessage());
		exit;
	}