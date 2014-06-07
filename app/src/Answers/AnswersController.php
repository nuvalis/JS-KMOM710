<?php

namespace nuvalis\Answers;
 
/**
 * A controller for answers and admin related events.
 *
 */
class AnswersController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->answers = new \nuvalis\Answers\Answers();
	    $this->answers->setDI($this->di);
	    $this->question = new \nuvalis\Questions\Questions();
	    $this->question->setDI($this->di);
	    $this->votes = new \nuvalis\Votes\Votes();
	    $this->votes->setDI($this->di);
	    $this->theme->setTitle("Application");
	}

	public function idAction($id)
	{

		$parent = $this->answers->getAnswerParent($id);
	 
		$this->redirectTo('questions/id/' . $parent);
	 
	    $this->theme->setTitle("Question");
	    $this->views->add('question/view_question', [
	        'question' => $question,
	        'answers' => $answers,
	    ]);

	   	$this->dispatcher->forward([
			'controller' => 'answers',
			'action'     => 'list-answers',
			'params'      => [$id],
		]);

		$this->question->countId($id);
	}

	public function newAction($questionID)
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
			'content' => [
				'type'        => 'textarea',
				'label'       => 'Content',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'submit' => [
				'type'      => 'submit',
				'callback'  => function($form) use ($questionID) {
			 
				    $this->answers->save([
				        'title' 	=> $form->Value('title'),
				        'content' 	=> $form->Value('content'),
				        'user_id' 	=> $this->auth->userid(),
				        'questions_id' 	=> $questionID,
				        'created' 	=> $this->mzHelpers->now(),
				    ]);

				    $this->question->save([
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
		 
		    $url = $this->url->create('questions/id/' . $questionID);
		    $this->response->redirect($url);
		
		} else if ($status === false) {
		
			// What to do when form could not be processed?
			$form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
			header("Location: " . $_SERVER['PHP_SELF']);
		}

		$this->theme->setTitle("New Answer");
		$this->views->add('question/new_question', [
			'title' => "New Answer",
			'form' => $form->getHTML()
		]);
	}

	public function listAnswersAction($id, $order)
	{

	    $answers = $this->answers->findAnswers($id, $order);

	    foreach ($answers as $a) {
	    	$a->comment = $this->answers->getAnswersComments($a->id);
	    }
	 
	    $this->theme->setTitle("Answers");
	    $this->views->add('answers/view_answers', [
	        'answers' => $answers,
	        'questionID' => $id,
	    ]);

	}
	 
}