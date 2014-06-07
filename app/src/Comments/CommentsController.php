<?php

namespace nuvalis\Comments;
 
/**
 * A controller for comments and admin related events.
 *
 */
class CommentsController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->comments = new \nuvalis\Comments\Comments();
	    $this->comments->setDI($this->di);
	    $this->questions = new \nuvalis\Questions\Questions();
	    $this->questions->setDI($this->di);
	    $this->theme->setTitle("Comment");
	}

	public function newAction($target, $ID)
	{

		$this->isLoggedIn();
		
 		$form = $this->form;

		$form = $form->create([], [
			'content' => [
				'type'        => 'textarea',
				'label'       => 'Content',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) use ($ID, $target) {
			 
				    $this->comments->save([
				        'content' 	=> $form->Value('content'),
				        'user_id' 	=> $this->auth->userid(),
				        $target . '_id' => $ID,
				        'created' 	=> $this->mzHelpers->now(),
				    ]);

				    $this->questions->save([
				    	'id' => $ID,
				        'updated' 	=> $this->mzHelpers->now(),
				    ]);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 
		    $url = $this->url->create($target . '/id/' . $ID);
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			// What to do when form could not be processed?
			$form->AddOutput("<p class='error'><i>Form was submitted and the Check() method returned false.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		}

		$this->theme->setTitle("New Comment");
		$this->views->add('question/new_question', [
			'title' => "New Comment",
			'form' => $form->getHTML()
		]);
	}

	public function listAnswersCommentsAction($id)
	{

		$comments = $this->comments->listAnswersComments($id);

		$this->theme->setTitle("Comment");
		$this->views->add('comments/list_comments', [
			'title' => "New Comment",
			'comments' => $comments
		]);

	}

	public function latestAction()
	{

		$comments = $this->comments->latestComments();

		$this->theme->setTitle("Comment");
		$this->views->add('comments/latest', [
			'comments' => $comments
		], 'sidebar');

	}
	 
}