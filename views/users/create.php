<h2><?php echo $viewdata['title']; ?></h2>

<?php if (strlen($viewdata['error']) > 0) : ?>
<div class="alert alert-danger" role="alert"><?php echo $viewdata['error']; ?></div>
<?php endif; ?>

<form class="form-horizontal" method="post">
	<hr />
	<input type="hidden" name="id" value="<?php echo $viewdata['user']['id']; ?>" />
	
	<div class="form-group">
		<label class="control-label col-md-2" for="firstname">First Name</label>
		<div class="col-md-10">
			<input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $viewdata['user']['firstname']; ?>" />
			<span class="text-danger"><?php echo $viewdata['firstnameerror']; ?></span>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-2" for="lastname">Last Name</label>
		<div class="col-md-10">
			<input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $viewdata['user']['lastname']; ?>" />
			<span class="text-danger"><?php echo $viewdata['lastnameerror']; ?></span>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-2" for="email">Email</label>
		<div class="col-md-10">
			<input type="text" class="form-control" id="email" name="email" value="<?php echo $viewdata['user']['email']; ?>" />
			<span class="text-danger"><?php echo $viewdata['emailerror']; ?></span>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-2">Roles</label>
		<div class="col-md-10">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="roles[]" value="Admin" <?php echo strpos($viewdata['user']['roles'], 'Admin') !== false ? 'checked' : ''; ?> />
					Admin
				</label>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-2 col-md-10">
			<input type="submit" value="Save" class="btn btn-default" />
		</div>
	</div>
</form>

<p>
	<a href="/users">Back to list</a>
</p>