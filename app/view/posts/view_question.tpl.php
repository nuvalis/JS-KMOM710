<h1><?= $post->title ?></h1>

<div class="question">
	<?= $post->content ?>	
</div>
<hr>
<div class="answers">

	<?php if(isset($answers)) : ?>
	<?php foreach($answers as $answer) : ?>

		<div class="answer-<?= $answer->id ?>">
			<?= $answer->content ?>
		</div>		

	<?php endforeach; ?> 
	<?php else : ?>
	
		<h3>No answers yet. Be the first one!</h3>
	
	<?php endif; ?>

</div>
<a href="<?= $this->url->create('answers/new/' . $post->id); ?>">New Answer</a>
