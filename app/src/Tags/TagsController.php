<?php

namespace nuvalis\Tags;
 
/**
 * A controller for tags and admin related events.
 *
 */
class TagsController extends \nuvalis\Base\ApplicationController
{

	public function initialize()
	{
	    $this->tags = new \nuvalis\Tags\Tags();
	    $this->tags->setDI($this->di);
	    $this->question = new \nuvalis\Questions\Questions();
	    $this->question->setDI($this->di);
	    $this->votes = new \nuvalis\Votes\Votes();
	    $this->votes->setDI($this->di);
	    $this->theme->setTitle("Tags");
	}

	public function indexAction()
	{

		$all = $this->tags->popularTags();

		$this->theme->setTitle("List all Tags");
	    $this->views->add('tags/list_tags', [
	        'tags' => $all,
	    ]);

	}

	public function sideTagsAction()
	{

		$all = $this->tags->popularTags(10);

		$this->theme->setTitle("List all Tags");
	    $this->views->add('tags/list_tags', [
	        'tags' => $all,
	    ], 'sidebar');

	}

	public function findAction($tag)
	{
		$all = $this->question->findByTag($tag);

		foreach($all as $q) {

			$q->answersCount = $this->question->countAnswers($q->questions_id);
			$q->tags 		 = $this->question->findTags($q->questions_id);
			$q->votes 		 = $this->votes->calcVotes("questions", $q->questions_id);
			$q->id 			 = $q->questions_id;

		}
	 
		$this->theme->setTitle("List all Questions");
	    $this->views->add('question/list_questions', [
	        'questions' => $all,
	        'title' => "View Questions By Tag " . $tag,
	    ]);
	}

	public function autoAction($term = null) 
	{

		if(isset($_POST['term'])){
			$term = $_POST['term'];
		}

		$res = $this->tags->searchTag($term);

		$this->json->render($res);

	}
	 
}