<?php

namespace nuvalis\Questions;
 
/**
 * A controller for posts and admin related events.
 *
 */
class QuestionsController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->question = new \nuvalis\Questions\Questions();
	    $this->question->setDI($this->di);
	   	$this->votes = new \nuvalis\Votes\Votes();
	    $this->votes->setDI($this->di);
	    $this->theme->setTitle("Questions");
	}

	public function indexAction()
	{

		$this->redirectTo('questions/list');

	}

	public function idAction($id, $order = 'created')
	{
	 
	    $question = $this->question->questionsByID($id);
	    $comments = $this->question->findComments($id);
	   	$tags = $this->question->findTags($id);
	 
	    $this->theme->setTitle("Question");
	    $this->views->add('question/view_question', [
	        'question' 	=> $question,
	        'comments' 	=> $comments,
	        'tags'		=> $tags,
	    ]);

	   	$this->dispatcher->forward([
			'controller' => 'answers',
			'action'     => 'list-answers',
			'params'      => [$id, $order],
		]);

		$this->sidebar();

		$this->question->countId($id);
	}

	public function listAction($order = 'created')
	{
	 
		$all = $this->question->orderList($order);

		foreach($all as $q) {
			$q->tags = $this->question->findTags($q->id);
		}
	 
		$this->theme->setTitle("List all Questions");
	    $this->views->add('question/list_questions', [
	        'questions' => $all,
	        'title' => "View all Questions",
	    ]);

	    $this->sidebar();

	}
	
	public function newAction()
	{

		$this->isLoggedIn();

 		$form = $this->form;

		$form = $form->create([], [
			'title' => [
				'type'        => 'text',
				'label'       => 'Title',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'tags' => [
				'type'        => 'text',
				'label'       => 'Tags',
				'required'    => true,
				'validation'  => ['not_empty'],
				'placeholder' => 'Comma separated list.',
			],
			'content' => [
				'type'        => 'textarea',
				'label'       => 'Content',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) {
			 
				    $this->question->save([
				        'title' 	=> $form->Value('title'),
				        'content' 	=> $form->Value('content'),
				        'user_id' 	=> $this->auth->userid(),
				        'cat_id' 	=> $this->auth->userid(),
				        'created' 	=> $this->mzHelpers->now(),
				    ]);

				    $lastQuestionID = $this->db->lastInsertId();

				    $this->question->addTags($form->Value('tags'), $lastQuestionID);

					return true;
				}
			],

		]);

		// Check the status of the form
		$status = $form->check();

		if ($status === true) {
		 
		    $url = $this->url->create('questions');
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			// What to do when form could not be processed?
			$form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		}

		$this->theme->setTitle("New Question");
		$this->views->add('question/new_question', [
			'title' => "New Question",
			'form' => $form->getHTML()
		]);
	}

	private function sidebar()
	{

		$this->dispatcher->forward([
			'controller' => 'users',
			'action'     => 'top-users',
		]);

	    $this->dispatcher->forward([
			'controller' => 'tags',
			'action'     => 'side-tags',
		]);

		$this->dispatcher->forward([
			'controller' => 'comments',
			'action'     => 'latest',
		]);

	}

}