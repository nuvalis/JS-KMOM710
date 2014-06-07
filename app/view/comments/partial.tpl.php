<div class="comments">
	<?php if ($comments): ?>
	
	<?php foreach($comments as $comment) : ?>	
			<div class="comment-post cid-<?= $comment->id ?>" data-comments-ID="<?= $comment->id ?>">
			
				<a class="comment-gravatar" href="<?= $this->url->create('users/id/' . $comment->user_id) ?>">
					<img class="gravatar" src="<?= $this->mzHelpers->get_gravatar($comment->email, 128); ?>" alt="">
				</a>

				<div class="content-main">
					<a class="comment-username" href="<?= $this->url->create('users/id/' . $comment->user_id) ?>">
						<?= $comment->username ?>
					</a>

					<span class="comment-date">Comment posted at <?= date("Y-m-d H:i", strtotime($comment->created)); ?></span>
					
					<div class="comment-content"><?= $this->textFilter->markdown($comment->content) ?></div>
				</div>	
				<div class="votes" data-commentsID="<?= $comment->id ?>">
					<a class="up-link"href="<?= $this->url->create("votes/up/comments/" . $comment->id) ?>">
						<div class="vote-up"></div>
					</a>
					<span class="vote-value"><?php if ($comment->votes == 0){echo "0";} else {echo $comment->votes;} ?></span>
					<a class="down-link" href="<?= $this->url->create("votes/down/comments/" . $comment->id) ?>">
						<div class="vote-down"></div>
					</a>
				</div>
			</div>
	<?php endforeach; ?>
		
	<?php else: ?>

		<p>No comments found for this question.</p>

	<?php endif ?>
</div>