<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>

			<h1><?php echo $results['pageTitle']?></h1>

			<form action="admin.php?action=<?php echo $results['formAction']?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>"/>

<?php if (isset($results['errorMessage'])) { ?>
				<div class="errorMessage"><?php echo $results['errorMessage']?></div>
<?php } ?>

				<ul>
					<li>
						<label for="title">Название</label>
						<input type="text" name="title" id="title" placeholder="Название записи" required autofocus maxlength="255" value="<?php echo htmlout($results['article']->title)?>" />
					</li>

					<li>
						<label for="summary">Краткое описание</label>
						<textarea name="summary" id="summary" placeholder="Краткое описание записи" required maxlength="1000" style="height: 5em;"><?php echo htmlout($results['article']->summary)?></textarea>
					</li>

					<li>
						<label for="content">Содержание</label>
						<textarea name="content" id="content" placeholder="HTML содержание записи" maxlength="100000" style="height: 30em;"><?php echo htmlout($results['article']->content)?></textarea>
					</li>

					<script src="tinymce/tinymce.min.js"></script>
					<script>
						tinymce.init({
							selector: 'textarea#content',
							height: 500,
							theme: 'modern',
							branding: false,
							language: 'ru',
							toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
							toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
							image_advtab: true,
							templates: [
								{title: 'Test template 1', content: 'Test 1'},
								{title: 'Test template 2', content: 'Test 2'} ],
							content_css: [
								'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
								'//www.tinymce.com/css/codepen.min.css'
							],
							plugins: [
								'advlist autolink lists link image charmap print preview hr anchor pagebreak',
								'searchreplace wordcount visualblocks visualchars code fullscreen',
								'insertdatetime media nonbreaking save table contextmenu directionality',
								'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
							]
							});
					</script>

					<li>
						<label for="categoryId">Article Category</label>
						<select name="categoryId">
							<option value="0"<?php echo !$results['article']->categoryId ? " selected" : ""?>>(none)</option>
						<?php foreach ( $results['categories'] as $category ) { ?>
							<option value="<?php echo $category->id?>"<?php echo ( $category->id == $results['article']->categoryId ) ? " selected" : ""?>><?php echo htmlspecialchars( $category->name )?></option>
						<?php } ?>
						</select>
					</li>

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
			<p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>" onclick="return confirm('Удалить статью?')">Удалить запись</a></p>
<?php } ?>

<?php include "templates/include/footer.php" ?>