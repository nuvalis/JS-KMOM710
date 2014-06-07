<div class="top-user-side">
<h3>Top Users</h3>

<?php foreach ($users as $user): ?>
	<p class="user-list">
	<span class="username"><a href="<?= $this->url->create('users/id/' . $user->id) ?>"><?= ucfirst($user->username) ?></a></span>
	<span class="points right"><?= $user->points ?> points</span>
	</p>
<?php endforeach ?>
</div>