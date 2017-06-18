<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>

			<h1><?php echo $results['pageTitle']?></h1>

<?php if (isset($results['errorMessage'])) { ?>
				<div class="errorMessage alert alert-danger" role="alert"><?php echo $results['errorMessage']?></div>
<?php } ?>

			<form class="form-horizontal" role="form" action="admin.php?action=<?php echo $results['formAction']?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>"/>
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Название</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="title" id="title" placeholder="Название записи" required autofocus maxlength="255" value="<?php echo htmlout($results['article']->title)?>"/>
						</div>
					</div>

					<div class="form-group">
						<label for="summary" class="col-sm-2 control-label">Краткое описание</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="3" name="summary" id="summary" placeholder="Краткое описание записи" required maxlength="1000" style="height: 5em;"><?php echo htmlout($results['article']->summary)?></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="content" class="col-sm-2 control-label">Содержание</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="content" id="content" maxlength="100000"><?php echo htmlout($results['article']->content)?></textarea>
						</div>
					</div>
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

					<div class="form-group">
						<label for="categoryId" class="col-sm-2 control-label">Категория</label>
						<div class="col-sm-10">
							<select name="categoryId" class="form-control">
				<option value="0"<?php echo !$results['article']->categoryId ? " selected" : ""?>>(none)</option>
				<?php foreach ($results['categories'] as $category) { ?>
					<option value="<?php echo $category->id?>"<?php echo ($category->id == $results['article']->categoryId) ? " selected" : ""?>><?php echo htmlout($category->name)?></option>
				<?php } ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="publicationDate" class="col-sm-2 control-label">Дата публикации</label>
						<div class="col-sm-10">
							<input type="date" class="form-control" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required autofocus maxlength="10" value="<?php echo $results['article']->publicationDate ? date("Y-m-d", $results['article']->publicationDate) : "" ?>"/>
						</div>
					</div>

					<?php if ($results['article'] && $imagePath = $results['article']->getImagePath()) { ?>
									<div class="form-group">
										<label for="articleImage" class="col-sm-2 control-label">Текущее изображение</label>
										<div class="col-sm-offset-2 col-sm-10">
											<img class="img-thumbnail img-responsive" id="articleImage" src="<?php echo $imagePath ?>" alt="Article Image"/>
										</div>
									</div>

									<div class="form-group">
										<label for="deleteImage" class="col-sm-2 control-label">Удалить</label>
										<div class="col-sm-10">
											<input type="checkbox" name="deleteImage" id="deleteImage" value="yes"/>
										</div>
									</div>
					<?php } ?>

				<div class="form-group">
					<label for="image" class="col-sm-2 control-label">Новое изображение</label>
					<div class="col-sm-10">
						<input type="file" name="image" id="image">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" name="saveChanges" class="btn btn-default" value="Сохранить"/>
						<input type="submit" class="btn btn-default" name="cancel" formnovalidate value="Отменить"/>
					</div>
				</div>
			</form>

<?php if ($results['article']->id) { ?>
			<p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>" onclick="return confirm('Удалить статью?')">Удалить запись</a></p>
<?php } ?>

<?php include "templates/include/footer.php" ?>
