
<h1><?= $user->name ?></h1>
<div class="user-box">
	<p>Acronym: <?= $user->username ?></p>
	<p>Email: <?= $user->email ?></p>
	<p>Status: <?php if($user->deleted !=  null) {echo "<span class='softdelete'>Deleted</span>";} else {echo "<span class='green-active'>Active</span>";} ?></p>
	<p>Last Activity: <?= $user->active ?></p>

	<p>
		<a href="<?= $this->url->create('users/change-password/' . $user->id); ?>">Change Password</a><br>
	</p>

	<p>
		Hash: <?= $user->password; ?>
	</p>

	<p>
		<a href="<?= $this->url->create('users/update/' . $user->id); ?>">Edit User</a><br>
	</p>

	<?php if ($user->deleted !=  null) : ?>
	<p>
		<a href="<?= $this->url->create('users/delete/' . $user->id); ?>">Perma Delete</a><br>
	</p>


	<?php endif; ?>
	<p>
		<a href="<?= $this->url->create('users/list'); ?>">Back to list</a>
	</p>
</div>