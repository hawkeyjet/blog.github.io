<?php include "templates/include/header.php" ?>

			<div id="adminHeader">
				<h2>Блог (Администратор)</h2>
				<p>Вы вошли как <b><?php echo htmlout($_SESSION['username'])?></b>. <a href="admin.php?action=logout"?>Выйти</a></p>
			</div>

			<h1>Все статьи</h1>

<?php if (isset( $results['errorMessage'])) { ?>
				<div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>


<?php if (isset($results['statusMessage'])) { ?>
				<div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

			<table>
				<tr>
					<th>Дата публикации</th>
					<th>Статья</th>
				</tr>

<?php foreach ($results['articles'] as $article) { ?>
				<tr onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>'">
					<td><?php echo date('j M Y', $article->publicationDate)?></td>
					<td>
						<?php echo $article->title?>
					</td>
				</tr>
<?php } ?>

			</table>

			<p>Количество статей: <?php echo $results['totalRows']?></p>

			<p><a href="admin.php?action=newArticle">Добавить новую статью</a></p>

<?php include "templates/include/footer.php" ?>

