<h1>Todays Quests</h1>

<div class="order smaller right">
	<span>Order By: </span>
	<a href="<?= $this->url->create('questions/list/created') ?>">Created</a>
	<a href="<?= $this->url->create('questions/list/votes') ?>">Votes</a>
	<a href="<?= $this->url->create('questions/list/views') ?>">Views</a>
	<a href="<?= $this->url->create('questions/list/active') ?>">Activity</a>
	<a href="<?= $this->url->create('questions/list/answers') ?>">Answers</a>
</div>

<?php foreach($questions as $question) : ?>
	<div class="question">

		<div class="votes">
			<p>Votes</p>
			<?php if ($question->votes == 0){echo "0";} else {echo $question->votes;} ?>
		</div>

		<div class="views">
			<p>Views</p>
			<?php if ($question->views == 0){echo "0";} else {echo $question->views;} ?>
		</div>
		
		<div class="answers">
			<p>Answers</p>
			<?php if ($question->answersCount == 0){echo "0";} else {echo $question->answersCount;} ?>
		</div>

		<h1 class="title-front"><a href="<?= $this->url->create('questions/id/' . $question->id); ?>"><?= $question->title; ?></a></h1>


		<?php if (isset($question->tags)): ?>
			<div class="tags">
				<?php foreach ($question->tags as $tag): ?>
					<a href="<?= $this->url->create('tags/find/' . $tag->tag_name); ?>" class="tag-link"><?= $tag->tag_name; ?></a>
				<?php endforeach ?>
			</div>
		<?php endif ?>
	</div>
<?php endforeach; ?> 

<p class="new-question"><a href="<?= $this->url->create('questions/new'); ?>">New Quest</a></p>