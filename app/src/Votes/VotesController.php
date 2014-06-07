<?php

namespace nuvalis\Votes;
 
/**
 * A controller for Votes and admin related events.
 *
 */
class VotesController extends \nuvalis\Base\ApplicationController
{

	/**
	 * Initialize the controller.
	 *
	 * @return void
	 */
	public function initialize()
	{
	    $this->votes = new \nuvalis\Votes\Votes();
	    $this->votes->setDI($this->di);
	    $this->theme->setTitle("Vote");
	}

	public function upAction($target, $id, $json = null)
	{

		$this->checkLogin($json);

		$vote = $this->votes->voteUp($id, $this->auth->userId(), $target);

		$this->voteJSON($json, $vote, $target, $id);

	}

	public function downAction($target, $id, $json = null)
	{
		
		$this->checkLogin($json);

		$vote = $this->votes->voteDown($id, $this->auth->userId(), $target);

		$this->voteJSON($json, $vote, $target, $id);
	 
	}

	private function checkLogin($json)
	{

		if (!$this->auth->isLoggedIn() && $json == 'json') {
			$this->json->render(['response' => 'Not logged in.']);
		} else {
			$this->isLoggedIn();
		}

	}

	private function voteJSON($json, $vote, $target, $id)
	{
		if($json == 'json' && $vote == true){
			$this->json->render(['response' => 'Success']);
		} else if ($json == 'json') {
			$this->flashy->cleanUp();
			$this->json->render(['response' => 'Could not vote. <br> You have probably already have voted on this post. Target ' . $target . ' ID' . $id]);
		} else {
			$this->flashy->success("Voted successfully");
			$this->redirectTo($target .'/id/'. $id);
		}
	}

	public function calcAction($target, $id) 
	{
		$this->votes->calcVotes($target, $id);
	}
	 
}