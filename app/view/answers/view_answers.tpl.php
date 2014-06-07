
<div id="answers-box" class="answers">
<h1>Answers</h1>
	<?php if($answers) : ?>
	<?php foreach($answers as $answer) : ?>

		<div class="answer aid-<?= $answer->id ?>">

			
			<div class="answer-group">
				<h2 class="title"><?= $answer->title ?></h2>
				<div class="answer-content"><?= $this->textFilter->markdown($answer->content) ?></div>
			</div>

			<div class="votes answer-votes" data-answersID="<?= $answer->id ?>">Votes
				<a class="up-link" href="<?= $this->url->create("votes/up/answers/" . $answer->id) ?>">
					<div class="vote-up"></div>
				</a>
				<span class="vote-value"><?php if ($answer->votes == 0){echo "0";} else {echo $answer->votes;} ?></span>
				<a class="down-link" href="<?= $this->url->create("votes/down/answers/" . $answer->id) ?>">
					<div class="vote-down"></div>
				</a>
			</div>

			<h3 class="clear">Comments</h3>
			<div class="comments">

			<?php if ($answer->comment): ?>

				<?php foreach($answer->comment as $comment) : ?>
						
					<div class="comment-post cid-<?= $comment->id ?>">
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

				<p>No comments found for this answer.</p>

			<?php endif ?>
			</div>

		</div>		

		<p><a href="<?= $this->url->create('comments/new/answers/' . $answer->id); ?>">Comment this Answer</a></p>

	<?php endforeach; ?> 
	<?php else : ?>
	
		<h3>No answers yet. Be the first one!</h3>
	
	<?php endif; ?>
<p class="new-answer"><a href="<?= $this->url->create('answers/new/' . $questionID); ?>">New Answer</a></p>
</div>

