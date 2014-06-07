<h1>Tags</h1>
<div class="tags">
	<?php foreach ($tags as $tag) : ?>

		<div class="tag-list">
			<a href="<?= $this->url->create('tags/find/' . $tag->tag_name); ?>" class="tag-link">
			<?= $tag->tag_name; ?>
			</a>
			<span class="smaller">x<?= $tag->count ?></span>
		</div>
		
	<?php endforeach; ?>
</div>