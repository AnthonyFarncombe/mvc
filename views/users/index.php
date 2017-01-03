<h2><?php echo $viewdata['title']; ?></h2>

<p>
	<a href="/users/create">Create new</a>
</p>

<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Email</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ( $viewdata['users']->num_rows > 0 ) {
			while ( $row = $viewdata['users']->fetch_assoc() ) {
		?>
		<tr>
			<td><a href="/users/details/<?php echo $row['id']; ?>"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></a></td>
			<td><?php echo $row['email']; ?></td>
		</tr>
		<?php
			}
		}
		?>
	</tbody>
</table>