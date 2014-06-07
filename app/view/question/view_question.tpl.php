<div id="question-box" class="question qid-<?= $question->id ?>">
<h1><?= $question->title ?></h1>

	<div class="posted-by smaller right">Asked by 
	<a href="<?= $this->url->create('users/id/' . $question->user_id) ?>"><?= $question->username ?></a> 
	on <?= date("Y-m-d H:i", strtotime($question->created)); ?></div>

	<div class="views">Views <br><br> <?php if ($question->views === 0){echo "0";} else {echo $question->views;} ?></div>
	<div class="votes" data-questionsID="<?= $question->id ?>">Votes
		<a class="up-link"href="<?= $this->url->create("votes/up/questions/" . $question->id) ?>">
			<div class="vote-up"></div>
		</a>
		<span class="vote-value"><?php if ($question->votes == 0){echo "0";} else {echo $question->votes;} ?></span>
		<a class="down-link" href="<?= $this->url->create("votes/down/questions/" . $question->id) ?>">
			<div class="vote-down"></div>
		</a>
	</div>
	
	<?php if (isset($tags)): ?>
		<div class="tags">
			<?php foreach ($tags as $tag): ?>
				<a href="<?= $this->url->create('tags/find/' . $tag->tag_name); ?>" class="tag-link"><?= $tag->tag_name; ?></a>
			<?php endforeach ?>
		</div>
	<?php endif ?>

	<div class="content clear">
		<?= $this->textFilter->markdown($question->content) ?>
	</div>

</div>

<h3 class="clear">Comments</h3>

<?php include ANAX_APP_PATH . '/view/comments/partial.tpl.php'; ?>

<p><a href="<?= $this->url->create('comments/new/questions/' . $question->id); ?>">Comment this Question</a></p>

<p class="order smaller right">
	<span>Order By: </span>
	<a href="<?= $this->url->create('questions/id/'. $question->id .'created') ?>">Created</a>
	<a href="<?= $this->url->create('questions/id/'. $question->id .'/votes') ?>">Votes</a>
</p>

