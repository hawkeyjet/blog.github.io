<?php include "templates/include/header.php" ?>
			<form class="form-horizontal" role="form" action="admin.php?action=login" method="post"">
				<input type="hidden" name="login" value="true" />
<?php if (isset($results['errorMessage'])) { ?>
					<div class="errorMessage alert alert-danger center-block" role="alert"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
				<div class="form-group">
					<label for="username" class="col-sm-2 control-label">Логин</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="username" id="username" placeholder="Логин Администратора" required autofocus maxlength="20"/>
					 </div>
				</div>

				<div class="form-group">
					<label for="password" class="col-sm-2 control-label">Пароль</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password" id="password" placeholder="Пароль" required autofocus maxlength="20"/>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" name="login" class="btn btn-default">Войти</button>
					</div>
				</div>
			</form>

<?php include "templates/include/footer.php" ?>