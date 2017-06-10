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
	case 'listCategories':
		listCategories();
		break;
	case 'newCategory':
		newCategory();
		break;
	case 'editCategory':
		editCategory();
		break;
	case 'deleteCategory':
		deleteCategory();
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
	$results['pageTitle'] = "Новая запись";
	$results['formAction'] = "newArticle";

	if (isset($_POST['saveChanges'])) {

		$article = new Article;
		$article->storeFormValues($_POST);
		$article->insert();

		if (isset($_FILES['image']))
			$article->storeUploadedImage($_FILES['image']);

		header("Location: admin.php?status=changesSaved");

	} elseif (isset($_POST['cancel'])) {
		header("Location: admin.php");

	} else {
		$results['article'] = new Article;
		$data = Category::getList();
		$results['categories'] = $data['results'];
		require TEMPLATE_PATH . "/admin/editArticle.php";
	}
}


function editArticle() {
	$results = array();
	$results['pageTitle'] = "Редактировать запись";
	$results['formAction'] = "editArticle";

	if (isset($_POST['saveChanges'])) {
		if (!$article = Article::getById((int)$_POST['articleId'])) {
			header("Location: admin.php?error=articleNotFound");
			return;
		}

		$article->storeFormValues($_POST);

		if (isset($_POST['deleteImage']) && $_POST['deleteImage'] == "yes")
			$article->deleteImages();

		$article->update();

		if (isset($_FILES['image']))
			$article->storeUploadedImage($_FILES['image']);

		header("Location: admin.php?status=changesSaved");

	} else if (isset($_POST['cancel'])) {
		header( "Location: admin.php" );

	} else {
		$results['article'] = Article::getById((int)$_GET['articleId']);
		$data = Category::getList();
		$results['categories'] = $data['results'];
		require TEMPLATE_PATH . "/admin/editArticle.php";
	}
}


function deleteArticle() {
	if (!$article = Article::getById((int)$_GET['articleId'])) {
		header("Location: admin.php?error=articleNotFound");
		return;
	}
	$article->deleteImages();
	$article->delete();
	header("Location: admin.php?status=articleDeleted");
}


function listArticles() {
	$results = array();
	$data = Article::getList();
	$results['articles'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$data = Category::getList();
	$results['categories'] = array();
	foreach ($data['results'] as $category) $results['categories'][$category->id] = $category;
	$results['pageTitle'] = "Все статьи";

	if (isset($_GET['error'])) {
		if ($_GET['error'] == "articleNotFound")
			$results['errorMessage'] = "Ошибка: Запись не найдена.";
	}

	if (isset($_GET['status'])) {
		if ($_GET['status'] == "changesSaved")
			$results['statusMessage'] = "Ваши изменения сохранены.";
		if ($_GET['status'] == "articleDeleted")
			$results['statusMessage'] = "Запись удалена.";
	}

	require TEMPLATE_PATH . "/admin/listArticles.php";
}

function listCategories() {
	$results = array();
	$data = Category::getList();
	$results['categories'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = "Article Categories";

	if (isset( $_GET['error'])) {
		if ($_GET['error'] == "categoryNotFound")
			$results['errorMessage'] = "Ошибка: Категория не найдена.";
		if ($_GET['error'] == "categoryContainsArticles")
			$results['errorMessage'] = "Ошибка: Категория содержит записи. Удалите записи или свяжите их с другими категориями, перед удалением этой категории.";
	}

	if (isset($_GET['status'])) {
		if ($_GET['status'] == "changesSaved") $results['statusMessage'] = "Ваши изменения сохранены.";
		if ($_GET['status'] == "categoryDeleted") $results['statusMessage'] = "Категория удалена.";
	}

	require TEMPLATE_PATH . "/admin/listCategories.php";
}

function newCategory() {
	$results = array();
	$results['pageTitle'] = "Категория новой записи";
	$results['formAction'] = "newCategory";

	if (isset($_POST['saveChanges'])) {
		$category = new Category;
		$category->storeFormValues($_POST);
		$category->insert();
		header("Location: admin.php?action=listCategories&status=changesSaved");

	} elseif (isset($_POST['cancel'])) {
		header( "Location: admin.php?action=listCategories" );
	} else {
		$results['category'] = new Category;
		require TEMPLATE_PATH . "/admin/editCategory.php";
	}
}

function editCategory() {

	$results = array();
	$results['pageTitle'] = "Редактировать категорию записи";
	$results['formAction'] = "editCategory";

	if (isset( $_POST['saveChanges'])) {
		if (!$category = Category::getById( (int)$_POST['categoryId'])) {
			header( "Location: admin.php?action=listCategories&error=categoryNotFound" );
			return;
		}

		$category->storeFormValues($_POST);
		$category->update();
		header("Location: admin.php?action=listCategories&status=changesSaved");

	} elseif (isset($_POST['cancel'])) {
		header("Location: admin.php?action=listCategories");

	} else {
		$results['category'] = Category::getById( (int)$_GET['categoryId']);
		require TEMPLATE_PATH . "/admin/editCategory.php";
	}
}

function deleteCategory() {
	if (!$category = Category::getById((int)$_GET['categoryId'])) {
		header("Location: admin.php?action=listCategories&error=categoryNotFound");
		return;
	}

	$articles = Article::getList(1000000, $category->id);

	if ($articles['totalRows'] > 0) {
		header( "Location: admin.php?action=listCategories&error=categoryContainsArticles" );
		return;
	}

	$category->delete();
	header("Location: admin.php?action=listCategories&status=categoryDeleted");
}