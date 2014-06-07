<h1>Todays Quests</h1>
<?php foreach($posts as $post) : ?>
	
	<h1> <a href="<?= $this->url->create('questions/id/' . $post->id); ?>"><?= $post->title; ?></a></h1>

<?php endforeach; ?> 

<hr>
<a href="<?= $this->url->create('questions/new'); ?>">New Quest</a>
