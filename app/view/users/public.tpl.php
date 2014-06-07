<h1><?= $user->name ?></h1>
<div class="user-box">

	<img class="gravatar right" src="<?= $this->mzHelpers->get_gravatar($user->email, 128); ?>" alt="">

	<p>Username: <?= $user->username ?></p>
	<p>Status: <?php if($user->deleted !=  null) {echo "<span class='softdelete'>Deleted</span>";} else {echo "<span class='green-active'>Active</span>";} ?></p>
	<p>Last Activity: <?= $user->active ?></p>

	<p>Points: <?=  $user->points->points ?> <br> 
	Answers: <?= $user->points->answers ?> <br>
	Comments: <?= $user->points->comments ?> <br> 
	Questions: <?= $user->points->questions ?> <br> 
	Votes: <?= $user->points->votes ?></p>
</div>

<?php if ($this->auth->userMatch($user->id)): ?>

	<div class="user-tools small">
		<p>
			<a href="<?= $this->url->create('users/update/' . $user->id ); ?>">Update Profile</a> <br>
			<a href="<?= $this->url->create('users/change-password/' . $user->id); ?>">Change Password</a>
		</p>
	</div>
	
<?php endif ?>


<div class="latest-questions">
<h3>Latest Questions</h3>
<?php if ($user->latestQuestions): ?>
	<?php foreach($user->latestQuestions as $question) : ?>
		<p><a href="<?= $this->url->create('questions/id/' . $question->id); ?>"><?= $question->title; ?></a></p>
	<?php endforeach; ?>
<?php else: ?>
	<p class="smaller"><?= ucfirst($user->username) ?> has not asked any questions yet.</p>
<?php endif; ?>
</div>

<div class="latest-answers">
<h3>Latest Answers</h3>
<?php if ($user->latestAnswers): ?>
	<?php foreach($user->latestAnswers as $answer) : ?>
		<p><a href="<?= $this->url->create('questions/id/' . $answer->questions_id); ?>"><?= $answer->title; ?></a></p>
	<?php endforeach; ?>
<?php else: ?>
	<p class="smaller"><?= ucfirst($user->username) ?> has not answered on anything yet.</p>
<?php endif; ?>
</div>

<div class="latest-comments">
<h3>Latest Comments</h3>
<?php if ($user->latestComments): ?>
	<?php foreach($user->latestComments as $comment) : ?>
		<div class="comment">
			<?php $content = $this->mzHelpers->naturalizeMD($comment->content, 144); ?>

			<p class="smaller"><?= $comment->created ?></p> 

			<?php if (isset($comment->questions_id)): ?>
				<p class="small"><a href="<?= $this->url->create('questions/id/' . $comment->questions_id); ?>"><?= $content ?></a></p>
			<?php elseif(isset($comment->answers_id)): ?>
				<p class="small"><a href="<?= $this->url->create('answers/id/' . $comment->answers_id); ?>"><?= $content ?></a></p>
			<?php endif ?>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<p class="smaller"><?= ucfirst($user->username) ?> has not commented on anything yet.</p>
<?php endif; ?>
</div>
