<h2><?php echo $viewdata['title']; ?></h2>

<?php if ($viewdata['user']['id'] === $_SESSION['id']) : ?>
<h4>You cannot delete the user you are logged in as!</h4>

<p>
	<a href="/users/details/<?php echo $viewdata['user']['id']; ?>">Cancel</a>
</p>
<?php else : ?>
<h3>Are you sure you want to delete this User?</h3>

<hr />

<dl class="dl-horizontal">
	<dt>First Name</dt>
	<dd><?php echo $viewdata['user']['firstname']; ?></dd>

	<dt>Last Name</dt>
	<dd><?php echo $viewdata['user']['lastname']; ?></dd>

	<dt>Email</dt>
	<dd><?php echo $viewdata['user']['email']; ?></dd>
	
	<dt>Roles</dt>
	<dd><?php echo implode(', ', explode('|', $viewdata['user']['roles'])); ?></dd>
</dl>

<form method="post">
	<input type="hidden" name="id" value="<?php echo $viewdata['user']['id']; ?>" />
	<input type="submit" value="Delete" class="btn btn-default" /> |
	<a href="/users/details/<?php echo $viewdata['user']['id']; ?>">Cancel</a>
</form>
<?php endif; ?>