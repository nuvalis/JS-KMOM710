<h3>Comments</h3>
<div class="comments">
<?php foreach($comments as $comment) : ?>
	
	<div class="comment-post">
		
		<?= $comment->content ?>

	</div>


<?php endforeach; ?>
</div>
