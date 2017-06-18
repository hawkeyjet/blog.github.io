<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>

			<h1><?php echo $results['pageTitle']?></h1>

			<form class="form-horizontal" role="form" action="admin.php?action=<?php echo $results['formAction']?>" method="post">
				<input type="hidden" name="categoryId" value="<?php echo $results['category']->id ?>"/>

<?php if (isset($results['errorMessage'])) { ?>
				<div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Название категории</label>
						<div class="col-sm-10">
							<input type="text" name="name" id="name" class="form-control" placeholder="Название категории" required autofocus maxlength="255" value="<?php echo htmlout($results['category']->name)?>" />
						</div>
					</div>

					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Описание</label>
						<div class="col-sm-10">
							<textarea name="description" id="description" class="form-control" placeholder="Краткое описание категории" required maxlength="1000" style="height: 5em;"><?php echo htmlout($results['category']->description)?></textarea>
						</div>
					</div>

				</ul>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" name="saveChanges" class="btn btn-default" value="Сохранить" />
						<input type="submit" formnovalidate name="cancel" class="btn btn-default" value="Отменить" />
					</div>
				</div>

			</form>

<?php if ($results['category']->id) { ?>
			<p><a href="admin.php?action=deleteCategory&amp;categoryId=<?php echo $results['category']->id ?>" onclick="return confirm('Удалить эту категорию?')">Удалить категорию</a></p>
<?php } ?>

<?php include "templates/include/footer.php" ?>