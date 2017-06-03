<?php include "templates/include/header.php" ?>

			<div id="adminHeader">
				<h2>Блог (Администратор)</h2>
				<p>Вы вошли как <b><?php echo htmlout($_SESSION['username'])?></b>. <a href="admin.php?action=logout"?>Выйти</a></p>
			</div>

			<h1><?php echo $results['pageTitle']?></h1>

			<form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
				<input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>"/>

<?php if (isset($results['errorMessage'])) { ?>
				<div class="errorMessage"><?php echo $results['errorMessage']?></div>
<?php } ?>

				<ul>
					<li>
						<label for="title">Название</label>
						<input type="text" name="title" id="title" placeholder="Название статьи" required autofocus maxlength="255" value="<?php echo htmlout($results['article']->title)?>" />
					</li>

					<li>
						<label for="summary">Краткое описание</label>
						<textarea name="summary" id="summary" placeholder="Краткое описание статьи" required maxlength="1000" style="height: 5em;"><?php echo htmlout($results['article']->summary)?></textarea>
					</li>

					<li>
						<label for="content">Содержание</label>
						<textarea name="content" id="content" placeholder="HTML содержание статьи" required maxlength="100000" style="height: 30em;"><?php echo htmlout($results['article']->content)?></textarea>
					</li>
					<script src="ckeditor/ckeditor.js"></script>
					<script>
						CKEDITOR.replace('content');
					</script>

					<li>
						<label for="publicationDate">Дата публикации</label>
						<input type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $results['article']->publicationDate ? date("Y-m-d", $results['article']->publicationDate) : "" ?>" />
					</li>
				</ul>

				<div class="buttons">
					<input type="submit" name="saveChanges" value="Сохранить" />
					<input type="submit" formnovalidate name="cancel" value="Отменить" />
				</div>

			</form>

<?php if ($results['article']->id) { ?>
			<p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>" onclick="return confirm('Удалить статью?')">Удалить статью</a></p>
<?php } ?>

<?php include "templates/include/footer.php" ?>