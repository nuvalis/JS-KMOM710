<h3>Latest Comments</h3>
<div class="comments">
<?php foreach($comments as $comment) : ?>

	<?php $content = $this->mzHelpers->naturalizeMD($comment->content); ?>
	
	<div class="comment-post">
		<div class="posted-by smaller">
		<a href="<?= $this->url->create('users/id/' . $comment->user_id) ?>">
		<?= ucfirst($comment->username) ?></a> posted a comment </div>
		<?php if (isset($comment->questions_id)): ?>
			<a href="<?= $this->url->create('questions/id/' . $comment->questions_id) ?>"><?= $content ?></a>	
		<?php elseif(isset($comment->answers_id)): ?>
			<a href="<?= $this->url->create('answers/id/' . $comment->answers_id) ?>"><?= $content ?></a>
		<?php endif ?>
	</div>
<?php endforeach; ?>
</div>