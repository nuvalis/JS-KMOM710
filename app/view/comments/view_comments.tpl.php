<h1><?= $question->title ?></h1>

<div class="question">
	<p><?php if ($question->views === 0){echo "0";}else{echo $question->views;} ?> views </p>
	
	<?= $question->content ?>	
</div>
<hr>
<div class="answers">

	<?php if(isset($answers)) : ?>
	<?php foreach($answers as $answer) : ?>

		<div class="answer-<?= $answer->id ?>">
			<h3><?= $answer->title ?></h3>

			<?= $answer->content ?>
		</div>		

	<?php endforeach; ?> 
	<?php else : ?>
	
		<h3>No answers yet. Be the first one!</h3>
	
	<?php endif; ?>

</div>
<a href="<?= $this->url->create('answers/new/' . $question->id); ?>">New Answer</a>
