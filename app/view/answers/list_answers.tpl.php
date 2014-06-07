<h1>Todays Quests</h1>
<?php foreach($questions as $question) : ?>
	
	<h1 class="question-title-front"><a href="<?= $this->url->create('questions/id/' . $question->id); ?>"><?= $question->title; ?></a></h1>

	<div class="views">
		<p>Views</p>
		<?php if ($question->views == 0){echo "0";} else {echo $question->views;} ?>
	</div>
	
	<div class="answers">
		<p>Answers</p>
		<?php if ($question->answersCount == 0){echo "0";} else {echo $question->answersCount;} ?>
	</div>

<?php endforeach; ?> 

<hr>
<a href="<?= $this->url->create('questions/new'); ?>">New Quest</a>
