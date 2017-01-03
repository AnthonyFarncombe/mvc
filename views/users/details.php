<h2><?php echo $viewdata['title']; ?></h2>

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

<p>
	<a href="/users/edit/<?php echo $viewdata['user']['id']; ?>">Edit</a> |
	<a href="/users/delete/<?php echo $viewdata['user']['id']; ?>">Delete</a> |
	<a href="/users">Back to list</a>
</p>