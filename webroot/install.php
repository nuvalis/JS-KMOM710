<?php

	require __DIR__.'/config_with_app.php';
	require __DIR__.'/custom.php'; // Custom Config

$app->router->add('install', function() use ($app) {

		$app->db->setVerbose();

		$app->theme->setTitle("Setup");
	 
		$app->db->dropTableIfExists('user')->execute();
	 
		$app->db->createTable(
			'user',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'username' => ['varchar(30)', 'unique', 'not null'],
				'email' => ['varchar(80)'],
				'name' => ['varchar(80)'],
				'password' => ['varchar(255)'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
				'active' => ['datetime'],
			]
		)->execute();

		$app->db->insert(
			'user',
			['username', 'email', 'name', 'password', 'created', 'active']
		);
	
		$now = $app->mzHelpers->now();
	
		$app->db->execute([
			'admin',
			'admin@test.se',
			'Administrator',
			password_hash('admin', PASSWORD_DEFAULT),
			$now,
			$now
		]);
	
		$app->db->execute([
			'doe',
			'doe@test.se',
			'John/Jane Doe',
			password_hash('doe', PASSWORD_DEFAULT),
			$now,
			$now
		]);

		$app->db->execute([
			'test',
			'test@test.se',
			'Test Testsson',
			password_hash('test', PASSWORD_DEFAULT),
			$now,
			$now
		]);
	 
		$app->db->setVerbose();

		$app->theme->setTitle("Setup");
	 
		$app->db->dropTableIfExists('questions')->execute();
		$app->db->dropTableIfExists('answers')->execute();
		$app->db->dropTableIfExists('comments')->execute();
		$app->db->dropTableIfExists('category')->execute();
		$app->db->dropTableIfExists('votes')->execute();
		$app->db->dropTableIfExists('tags')->execute();
		$app->db->dropTableIfExists('questions_cat_ref')->execute();
		$app->db->dropTableIfExists('questions_tag_ref')->execute();
		$app->db->dropTableIfExists('questions_answers_ref')->execute();
		$app->db->dropTableIfExists('questions_comments_ref')->execute();
		$app->db->dropTableIfExists('answers_comments_ref')->execute();
		
		$app->db->createTable(
			'questions',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'cat_id' => ['integer'],
				'user_id' => ['integer', 'not null'],
				'title' => ['varchar(128)', 'not null'],
				'content' => ['text', 'not null'],
				'views' => ['integer'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
			]
		)->execute();

		$app->db->createTable(
			'answers',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'questions_id' => ['integer', 'not_null'],
				'user_id' => ['integer', 'not null'],
				'title' => ['varchar(128)', 'not null'],
				'content' => ['text', 'not null'],
				'accepted' => ['boolean'],
				'views' => ['integer'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
			]
		)->execute();

		$app->db->createTable(
			'comments',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'user_id' => ['integer', 'not null'],
				'questions_id' => ['integer'],
				'answers_id' => ['integer'],
				'content' => ['text', 'not null'],
				'views' => ['integer'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
			]
		)->execute();

		$app->db->createTable(
			'category',
			[
				'cat_id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'name' => ['varchar(64)'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
			]
		)->execute();

		$app->db->createTable(
			'votes',
			[
				'votes_id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'questions_id' => ['integer'],
				'answers_id' => ['integer'],
				'comments_id' => ['integer'],
				'user_id' => ['integer', 'not null'],
				'vote_value' => ['integer', 'not null'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
			]
		)->execute();

		$app->db->createTable(
			'tags',
			[
				'tag_id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'tag_name' => ['varchar(128)', 'unique'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
			]
		)->execute();

		$app->db->createTable(
			'questions_tag_ref',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'tag_id' => ['integer', 'not null'],
				'questions_id' => ['integer', 'not null'],
			]
		)->execute();

		$app->db->createTable(
			'questions_cat_ref',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'cat_id' => ['integer', 'not null'],
				'questions_id' => ['integer', 'not null'],
			]
		)->execute();

		$app->db->createTable(
			'answers_comments_ref',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'comments_id' => ['integer', 'not null'],
				'answers_id' => ['integer', 'not null'],
			]
		)->execute();

		$app->db->createTable(
			'questions_comments_ref',
			[
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'comments_id' => ['integer', 'not null'],
				'questions_id' => ['integer', 'not null'],
			]
		)->execute();


		$app->db->execute(
						"PRAGMA foreign_keys = ON;
						ALTER TABLE `questions`  
						ADD CONSTRAINT `fk_questions_cat_id` 
    					FOREIGN KEY (`cat_id`) REFERENCES `questions_tag_ref` (`cat_id`) ON DELETE CASCADE;");

		$app->db->execute(
						"PRAGMA foreign_keys = ON;
						ALTER TABLE `questions`  
						ADD CONSTRAINT `fk_questions_tag_id` 
    					FOREIGN KEY (`tag_id`) REFERENCES `questions_cat_ref` (`tag_id`) ON DELETE CASCADE;");

		$app->db->execute(
						"PRAGMA foreign_keys = ON;
						ALTER TABLE `questions_cat_ref`  
						ADD CONSTRAINT `fk_questions_ref_cat_id` 
    					FOREIGN KEY (`tag_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE;");

		$app->db->execute(
						"PRAGMA foreign_keys = ON;
						ALTER TABLE `questions_tag_ref`  
						ADD CONSTRAINT `fk_questions_ref_tag_id` 
    					FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;");
		


		$app->flashy->success("Setup is Done, Please delete the webroot/install.php file");

	    $url = $app->url->create('');
	    $app->response->redirect($url);
		
	});

	 
	$app->router->handle();
	$app->theme->render();