<h1><?=$title?></h1>

<table class="col-12">
	<tbody>
		<tr>
			<th>ID</th>
			<th>Acronym</th>
			<th>Name</th>
			<th>Email</th>
			<th>Status</th>
			<th>Update</th>
			<th>Tools</th>
		</tr>

		<?php foreach ($users as $user) : ?>
			<tr>
			<td><?= $user->id ?></td>
			<td><a href="<?= $this->url->create('users/id/' . $user->id ); ?>"><?= $user->username ?></a></td>
			<td><?= $user->name ?></td>
			<td><?= $user->email ?></td>
			<td><?php if($user->deleted !=  null) {echo "<span class='softdelete'>Deleted</span>";} else {echo "<span class='green-active'>Active</span>";} ?></td>
			<td><a href="<?= $this->url->create('users/update/' . $user->id ); ?>">Update</a></td>
			<?php if($user->deleted === null) : ?>
				<td><a href="<?= $this->url->create('users/softdelete/' . $user->id ); ?>">Delete</a></td>
			<?php else : ?>
				<td><a href="<?= $this->url->create('users/undosoftdelete/' . $user->id ); ?>">Undo</a></td>
			<?php endif; ?>
			
			</tr>


		<?php endforeach; ?>

	</tbody>
</table>

<div class="create-user">
		
		<h1>Actions</h1>
		<a href="<?= $this->url->create('users/add/'); ?>">Add User</a><br>
		<a href="<?= $this->url->create('setup'); ?>">Setup/Reset DB</a><br>
		<a href="<?= $this->url->create('users/active'); ?>">View active users only</a><br>
		<a href="<?= $this->url->create('users/list'); ?>">List all</a><br>
		<a href="<?= $this->url->create('users/inactive'); ?>">List all inactive/deleted</a><br>

</div>
