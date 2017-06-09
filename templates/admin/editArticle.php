<?php include "templates/include/header.php" ?>

			<div id="adminHeader">
				<h2>Блог (Администратор)</h2>
				<p>Вы вошли как <b><?php echo htmlout($_SESSION['username'])?></b>. <a href="admin.php?action=logout"?>Выйти</a></p>
			</div>

			<h1><?php echo $results['pageTitle']?></h1>

			<form action="admin.php?action=<?php echo $results['formAction']?>" method="post" enctype="multipart/form-data">
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
						<textarea name="content" id="content" placeholder="HTML содержание статьи" maxlength="100000" style="height: 30em;"><?php echo htmlout($results['article']->content)?></textarea>
					</li>

					<script src="tinymce/tinymce.min.js"></script>
					<script>
						tinymce.init({
							selector: 'textarea#content',
							branding: false,
							language: 'ru',
							plugins: 'advlist, anchor, autolink, autoresize, autosave, charmap, code, codesample, colorpicker, contextmenu, directionality, fullscreen, help, hr, image, imagetools, importcss, insertdatetime, legacyoutput, link, lists, media, nonbreaking, noneditable, pagebreak, paste, preview, print, save, searchreplace, tabfocus, table, template, textcolor, textpattern, toc, visualblocks, visualchars, wordcount'
							})
					</script>

					<li>
						<label for="publicationDate">Дата публикации</label>
						<input type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $results['article']->publicationDate ? date("Y-m-d", $results['article']->publicationDate) : "" ?>" />
					</li>

<?php if ($results['article'] && $imagePath = $results['article']->getImagePath()) { ?>
					<li>
						<label>Текущее изображение</label>
						<img id="articleImage" src="<?php echo $imagePath ?>" alt="Article Image" />
					</li>

					<li>
						<label for="deleteImage">Удалить</label><input type="checkbox" name="deleteImage" id="deleteImage" value="yes" />
					</li>
<?php } ?>

					<li>
						<label for="image">Новое изображение</label>
						<input type="file" name="image" id="image" placeholder="Выберите изображение для загрузки" maxlength="255" />
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