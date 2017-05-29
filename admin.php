<?php

require "config.php";
session_start();
$action = isset($_GET['action']) ? $_GET['action'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";

if ($action != "login" && $action != "logout" && !$username) {
	login();
	exit;
}

switch ($action) {
	case 'login':
		login();
		break;
	case 'logout':
		logout();
		break;
	case 'newArticle':
		newArticle();
		break;
	case 'editArticle':
		editArticle();
		break;
	case 'deleteArticle':
		deleteArticle();
		break;
	default:
		listArticles();
}


function login() {
	$results = array();
	$results['pageTitle'] = "Вход | Блог";

	if (isset($_POST['login'])) {
		if ($_POST['username'] == ADMIN_USER && $_POST['password'] == ADMIN_PASS) {
			$_SESSION['username'] = ADMIN_USER;
			header("Location: admin.php");

		} else {
			$results['errorMessage'] = "Неверное имя пользователя или пароль. Попробуйте еще раз.";
			require TEMPLATE_PATH . "/admin/loginForm.php";
		}

	} else {
		require( TEMPLATE_PATH . "/admin/loginForm.php" );
	}
}


function logout() {
	unset( $_SESSION['username'] );
	header( "Location: admin.php" );
}


function newArticle() {
	$results = array();
	$results['pageTitle'] = "Новая статья";
	$results['formAction'] = "newArticle";

	if (isset( $_POST['saveChanges'])) {

		$article = new Article;
		$article->storeFormValues($_POST);
		$article->insert();
		header("Location: admin.php?status=changesSaved");

	} elseif ( isset( $_POST['cancel'] ) ) {
		header( "Location: admin.php" );

	} else {
		$results['article'] = new Article;
		require TEMPLATE_PATH . "/admin/editArticle.php";
	}
}


function editArticle() {
	$results = array();
	$results['pageTitle'] = "Редактировать статью";
	$results['formAction'] = "editArticle";

	if (isset($_POST['saveChanges'])) {
		if (!$article = Article::getById((int)$_POST['articleId'])) {
			header("Location: admin.php?error=articleNotFound");
			return;
		}

		$article->storeFormValues($_POST);
		$article->update();
		header("Location: admin.php?status=changesSaved");

	} else if (isset($_POST['cancel'])) {
		header( "Location: admin.php" );

	} else {
		$results['article'] = Article::getById((int)$_GET['articleId']);
		require TEMPLATE_PATH . "/admin/editArticle.php";
	}
}


function deleteArticle() {
	if (!$article = Article::getById((int)$_GET['articleId'])) {
		header("Location: admin.php?error=articleNotFound");
		return;
	}
	$article->delete();
	header("Location: admin.php?status=articleDeleted");
}


function listArticles() {
	$results = array();
	$data = Article::getList();
	$results['articles'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = "Все статьи";

	if (isset( $_GET['error'])) {
		if ($_GET['error'] == "articleNotFound")
			$results['errorMessage'] = "Ошибка: Статья не найдена.";
	}

	if (isset( $_GET['status'])) {
		if ($_GET['status'] == "changesSaved")
			$results['statusMessage'] = "Ваши изменения сохранены.";
		if ($_GET['status'] == "articleDeleted")
			$results['statusMessage'] = "Статья удалена.";
	}

	require TEMPLATE_PATH . "/admin/listArticles.php";
}