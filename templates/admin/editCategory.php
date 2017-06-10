<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>

			<h1><?php echo $results['pageTitle']?></h1>

			<form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
				<input type="hidden" name="categoryId" value="<?php echo $results['category']->id ?>"/>

<?php if (isset($results['errorMessage'])) { ?>
				<div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

				<ul>

					<li>
						<label for="name">Название категории</label>
						<input type="text" name="name" id="name" placeholder="Название категории" required autofocus maxlength="255" value="<?php echo htmlout($results['category']->name)?>" />
					</li>

					<li>
						<label for="description">Описание</label>
						<textarea name="description" id="description" placeholder="Краткое описание категории" required maxlength="1000" style="height: 5em;"><?php echo htmlout($results['category']->description)?></textarea>
					</li>

				</ul>

				<div class="buttons">
					<input type="submit" name="saveChanges" value="Save Changes" />
					<input type="submit" formnovalidate name="cancel" value="Cancel" />
				</div>

			</form>

<?php if ($results['category']->id) { ?>
			<p><a href="admin.php?action=deleteCategory&amp;categoryId=<?php echo $results['category']->id ?>" onclick="return confirm('Удалить эту категорию?')">Удалить категорию</a></p>
<?php } ?>

<?php include "templates/include/footer.php" ?>