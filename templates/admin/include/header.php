<div id="adminHeader">
	<h2>Блог (Администратор)</h2>
	<p>Вы вошли как <b><?php echo htmlout($_SESSION['username']) ?></b>.
	<a class="btn btn-default" role="button" href="admin.php?action=listArticles">Редактировать записи</a>
	<a class="btn btn-default" role="button" href="admin.php?action=listCategories">Редактировать категории</a>
	<a class="btn btn-default" role="button" href="admin.php?action=logout"?>Выйти</a></p>
</div>